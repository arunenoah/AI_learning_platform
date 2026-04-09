<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class IngestLinkController extends Controller
{
    public function handle(Request $request): JsonResponse
    {
        // Verify shared secret
        if ($request->header('X-Agent-Secret') !== config('services.agent.secret')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $url = $request->input('url');

        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            return response()->json(['message' => 'Invalid URL'], 422);
        }

        // Clean tracking params
        $url = $this->cleanUrl($url);

        // Duplicate check
        if (Resource::where('url', $url)->exists()) {
            return response()->json(['message' => 'URL already exists in the blog'], 409);
        }

        // Fetch page meta
        $meta = $this->fetchMeta($url);

        // Analyse and categorise
        $analysis = config('services.anthropic.api_key')
            ? $this->analyzeWithClaude($url, $meta)
            : $this->analyzeWithHeuristics($url, $meta);

        // Create resource
        $resource = Resource::create([
            'title'            => Str::limit($meta['title'], 255),
            'description'      => Str::limit($meta['description'], 500),
            'learning_reason'  => $analysis['learning_reason'],
            'category'         => $analysis['category'],
            'type'             => $analysis['type'],
            'url'              => $url,
            'content'          => null,
            'duration_minutes' => $analysis['duration'],
            'difficulty_level' => $analysis['difficulty'],
            'icon'             => $analysis['icon'],
            'is_active'        => true,
        ]);

        Log::info("WhatsApp agent added resource: {$resource->title} ({$url})");

        return response()->json(['resource' => $resource], 201);
    }

    // ─── URL Cleaning ─────────────────────────────────────────────────────────

    private function cleanUrl(string $url): string
    {
        $parsed = parse_url($url);
        if (! $parsed) return $url;

        // Remove UTM and tracking params
        $remove = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term', 'ref', 'fbclid', 'gclid'];

        if (isset($parsed['query'])) {
            parse_str($parsed['query'], $params);
            foreach ($remove as $key) unset($params[$key]);
            $parsed['query'] = $params ? http_build_query($params) : null;
        }

        $clean  = ($parsed['scheme'] ?? 'https') . '://';
        $clean .= $parsed['host'] ?? '';
        $clean .= $parsed['path'] ?? '';
        if (! empty($parsed['query'])) $clean .= '?' . $parsed['query'];

        return rtrim($clean, '/');
    }

    // ─── Meta Fetching ────────────────────────────────────────────────────────

    private function fetchMeta(string $url): array
    {
        try {
            $response = Http::timeout(12)
                ->withHeaders(['User-Agent' => 'Mozilla/5.0 (compatible; LearnHubBot/1.0)'])
                ->get($url);

            $html = $response->body();

            $title = $this->metaTag($html, 'og:title')
                  ?? $this->metaTag($html, 'twitter:title')
                  ?? $this->pageTitle($html)
                  ?? 'Untitled';

            $description = $this->metaTag($html, 'og:description')
                        ?? $this->metaTag($html, 'twitter:description')
                        ?? $this->metaTag($html, 'description')
                        ?? '';

            $siteName = $this->metaTag($html, 'og:site_name')
                     ?? parse_url($url, PHP_URL_HOST);

            return compact('title', 'description', 'siteName');

        } catch (\Throwable $e) {
            Log::warning("Meta fetch failed for {$url}: " . $e->getMessage());
            $host = parse_url($url, PHP_URL_HOST) ?? 'Resource';
            return ['title' => $host, 'description' => '', 'siteName' => $host];
        }
    }

    private function metaTag(string $html, string $property): ?string
    {
        // property="..." content="..."
        if (preg_match(
            '/<meta[^>]+(?:property|name)=["\']' . preg_quote($property, '/') . '["\'][^>]+content=["\']([^"\']{1,600})["\']/',
            $html, $m
        )) {
            return html_entity_decode(trim($m[1]));
        }
        // content="..." property="..."
        if (preg_match(
            '/<meta[^>]+content=["\']([^"\']{1,600})["\'][^>]+(?:property|name)=["\']' . preg_quote($property, '/') . '["\']/',
            $html, $m
        )) {
            return html_entity_decode(trim($m[1]));
        }
        return null;
    }

    private function pageTitle(string $html): ?string
    {
        if (preg_match('/<title[^>]*>([^<]{1,300})<\/title>/i', $html, $m)) {
            return html_entity_decode(trim($m[1]));
        }
        return null;
    }

    // ─── Claude Analysis ──────────────────────────────────────────────────────

    private function analyzeWithClaude(string $url, array $meta): array
    {
        $categories = implode(', ', [
            'Claude Code', 'Claude API', 'Claude Agent SDK', 'MCP',
            'Prompt Engineering', 'AI Agents', 'AI Coding', 'AI Frameworks',
            'Inference Tools', 'ML Foundations', 'Deep Learning', 'LLMs',
            'Reinforcement Learning', 'MLOps', 'Google AI', 'CS Fundamentals',
            'Free Textbooks', 'YouTube', 'AI News',
        ]);

        try {
            $response = Http::withHeaders([
                'x-api-key'         => config('services.anthropic.api_key'),
                'anthropic-version' => '2023-06-01',
                'content-type'      => 'application/json',
            ])->timeout(15)->post('https://api.anthropic.com/v1/messages', [
                'model'      => 'claude-haiku-4-5-20251001',
                'max_tokens' => 300,
                'messages'   => [[
                    'role'    => 'user',
                    'content' =>
                        "Analyze this learning resource. Return JSON only, no markdown.\n\n" .
                        "URL: {$url}\n" .
                        "Title: {$meta['title']}\n" .
                        "Description: {$meta['description']}\n" .
                        "Site: {$meta['siteName']}\n\n" .
                        "Return exactly:\n" .
                        "{\n" .
                        "  \"category\": \"one of [{$categories}]\",\n" .
                        "  \"type\": \"Article|Video|Tutorial|Course|Documentation|Blog|Tool|Book\",\n" .
                        "  \"difficulty\": 1 or 2 or 3,\n" .
                        "  \"duration\": estimated_reading_minutes_as_integer,\n" .
                        "  \"learning_reason\": \"one sentence why this is valuable\",\n" .
                        "  \"icon\": \"single relevant emoji\"\n" .
                        "}",
                ]],
            ]);

            $text = $response->json('content.0.text', '');

            // Extract JSON even if Claude wraps it
            preg_match('/\{[\s\S]+\}/', $text, $m);
            $data = json_decode($m[0] ?? $text, true);

            if ($data && isset($data['category'])) {
                return [
                    'category'        => $data['category'],
                    'type'            => ucfirst(strtolower($data['type'] ?? 'article')),
                    'difficulty'      => max(1, min(3, (int) ($data['difficulty'] ?? 1))),
                    'duration'        => max(1, (int) ($data['duration'] ?? 10)),
                    'learning_reason' => $data['learning_reason'] ?? "Learn from: {$meta['title']}",
                    'icon'            => $data['icon'] ?? '📄',
                ];
            }
        } catch (\Throwable $e) {
            Log::warning('Claude analysis failed: ' . $e->getMessage());
        }

        return $this->analyzeWithHeuristics($url, $meta);
    }

    // ─── Heuristic Fallback ───────────────────────────────────────────────────

    private function analyzeWithHeuristics(string $url, array $meta): array
    {
        $text = strtolower($meta['title'] . ' ' . $meta['description'] . ' ' . $url);
        $host = strtolower(parse_url($url, PHP_URL_HOST) ?? '');

        $category = match (true) {
            str_contains($text, 'claude code')                            => 'Claude Code',
            str_contains($text, 'claude api') || str_contains($text, 'claude')  => 'Claude API',
            str_contains($text, 'mcp') || str_contains($text, 'model context')  => 'MCP',
            str_contains($text, 'prompt engineer')                        => 'Prompt Engineering',
            str_contains($text, 'agent')                                  => 'AI Agents',
            str_contains($text, 'langchain') || str_contains($text, 'llamaindex') => 'AI Frameworks',
            str_contains($text, 'llm') || str_contains($text, 'gpt') || str_contains($text, 'gemini') => 'LLMs',
            str_contains($text, 'deep learning') || str_contains($text, 'neural') => 'Deep Learning',
            str_contains($text, 'machine learning')                       => 'ML Foundations',
            str_contains($text, 'mlops') || str_contains($text, 'deployment') => 'MLOps',
            str_contains($host, 'youtube.com') || str_contains($host, 'youtu.be') => 'YouTube',
            str_contains($text, 'google') || str_contains($text, 'gemini') => 'Google AI',
            default                                                        => 'AI News',
        };

        $type = match (true) {
            str_contains($host, 'youtube.com') || str_contains($host, 'youtu.be') => 'Video',
            str_contains($host, 'arxiv.org')                              => 'Article',
            str_contains($text, 'tutorial') || str_contains($text, 'how to') => 'Tutorial',
            str_contains($text, 'course') || str_contains($host, 'coursera') || str_contains($host, 'udemy') => 'Course',
            str_contains($text, 'docs.') || str_contains($text, 'documentation') || str_contains($host, 'docs.') => 'Documentation',
            default => 'Blog',
        };

        $difficulty = match (true) {
            str_contains($text, 'advanced') || str_contains($text, 'expert') || str_contains($text, 'deep dive') => 3,
            str_contains($text, 'intermediate') || str_contains($text, 'building') => 2,
            default => 1,
        };

        $icon = match ($type) {
            'Video'         => '🎬',
            'Tutorial'      => '📚',
            'Course'        => '🎓',
            'Documentation' => '📖',
            'Article'       => '📝',
            default         => '🌐',
        };

        return [
            'category'        => $category,
            'type'            => $type,
            'difficulty'      => $difficulty,
            'duration'        => 10,
            'learning_reason' => "Learn from: {$meta['title']}",
            'icon'            => $icon,
        ];
    }
}
