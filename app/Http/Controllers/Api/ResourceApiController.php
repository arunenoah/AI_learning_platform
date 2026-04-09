<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResourceApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $type = $request->get('type', 'skills');
        
        $query = Resource::active();
        
        if ($type && $type !== 'all') {
            $typeMapping = [
                'skills' => 'Course',
                'agents' => 'GitHub',
                'commands' => 'Tool',
                'mcps' => 'Tool',
                'settings' => 'Docs',
                'hooks' => 'GitHub',
                'templates' => 'GitHub',
                'plugins' => 'GitHub',
            ];
            
            if (isset($typeMapping[$type])) {
                $query->where('type', $typeMapping[$type]);
            }
        }
        
        $category = $request->get('category', 'all');
        if ($category && $category !== 'all') {
            $query->where('category', $category);
        }
        
        $resources = $query->orderBy('title')->get();
        
        $formatted = $resources->map(function ($resource) {
            return [
                'name' => $resource->title,
                'path' => $resource->url,
                'category' => $resource->category,
                'type' => strtolower($resource->type),
                'description' => $resource->description,
                'content' => $resource->content ?? '',
                'author' => '',
                'repo' => '',
                'version' => '',
                'license' => '',
                'keywords' => [],
                'downloads' => 0,
                'security' => [
                    'validated' => false,
                    'valid' => null,
                    'score' => null,
                    'errorCount' => 0,
                    'warningCount' => 0,
                    'lastValidated' => null,
                ],
            ];
        });
        
        $result = [
            'skills' => $formatted->where('category', 'Claude Code')->values()->toArray(),
            'agents' => [],
            'commands' => [],
            'mcps' => [],
            'settings' => [],
            'hooks' => [],
            'templates' => [],
            'plugins' => [],
        ];
        
        return response()->json($result);
    }

    public function show(Resource $resource): JsonResponse
    {
        return response()->json([
            'name' => $resource->title,
            'path' => $resource->url,
            'category' => $resource->category,
            'type' => strtolower($resource->type),
            'description' => $resource->description,
            'content' => $resource->content ?? '',
            'author' => '',
            'repo' => '',
            'version' => '',
            'license' => '',
            'keywords' => [],
            'downloads' => 0,
            'security' => [
                'validated' => false,
                'valid' => null,
                'score' => null,
                'errorCount' => 0,
                'warningCount' => 0,
                'lastValidated' => null,
            ],
        ]);
    }
}
