<?php

namespace App\Console\Commands;

use App\Models\Resource;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ImportClaudeCodeMaterials extends Command
{
    protected $signature = 'import:claude-materials {--dry-run : Show what would be imported without saving}';
    protected $description = 'Import Claude Code materials from public/data.json into resources table';

    public function handle(): int
    {
        $path = public_path('data.json');

        if (! file_exists($path)) {
            $this->error("data.json not found at: {$path}");
            return 1;
        }

        $data = json_decode(file_get_contents($path), true);

        if (! $data) {
            $this->error('Failed to parse data.json');
            return 1;
        }

        $types = ['skills', 'agents', 'commands', 'mcps', 'settings', 'hooks', 'templates', 'plugins'];
        $imported = 0;
        $skipped = 0;

        foreach ($types as $type) {
            $items = $data[$type] ?? [];
            $this->line("Processing <info>{$type}</info>: " . count($items) . " items");

            foreach ($items as $item) {
                $title = $item['name'] ?? null;

                if (! $title) {
                    continue;
                }

                // Skip duplicates by title
                if (Resource::where('title', $title)->exists()) {
                    $skipped++;
                    continue;
                }

                $description = $item['description'] ?? '';
                $content     = $item['content'] ?? null;

                $difficulty = match (true) {
                    Str::contains(strtolower($description), ['advanced', 'expert', 'complex', 'architect']) => 3,
                    Str::contains(strtolower($description), ['intermediate', 'engineer', 'implement'])       => 2,
                    default => 1,
                };

                if (! $this->option('dry-run')) {
                    Resource::create([
                        'title'            => $title,
                        'description'      => Str::limit($description, 500),
                        'learning_reason'  => "Learn about {$title} — a Claude Code {$type} resource.",
                        'category'         => 'Claude Code',
                        'type'             => Str::ucfirst($type),
                        'url'              => null,
                        'content'          => $content,
                        'duration_minutes' => 10,
                        'difficulty_level' => $difficulty,
                        'icon'             => $this->iconFor($type),
                        'is_active'        => true,
                    ]);
                }

                $this->line("  ✓ {$title}");
                $imported++;
            }
        }

        $this->newLine();

        if ($this->option('dry-run')) {
            $this->info("Dry run: would import {$imported}, skip {$skipped} duplicates");
        } else {
            $this->info("Done. Imported: {$imported}, skipped duplicates: {$skipped}");
        }

        return 0;
    }

    private function iconFor(string $type): string
    {
        return match ($type) {
            'skills'    => '✨',
            'agents'    => '🤖',
            'commands'  => '⌘',
            'mcps'      => '🔧',
            'settings'  => '⚙️',
            'hooks'     => '🪝',
            'templates' => '📄',
            'plugins'   => '🧩',
            default     => '📚',
        };
    }
}
