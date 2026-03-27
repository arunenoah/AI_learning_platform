<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    public function run(): void
    {
        $badges = [
            [
                'name' => 'First Explorer',
                'description' => 'Visit 10 resources',
                'slug' => 'first-explorer',
                'icon' => '🔍',
                'type' => 'resources_completed',
                'requirement_value' => 10,
                'requirement_type' => 'count',
            ],
            [
                'name' => 'Resource Collector',
                'description' => 'Complete 20 resources',
                'slug' => 'resource-collector',
                'icon' => '📚',
                'type' => 'resources_completed',
                'requirement_value' => 20,
                'requirement_type' => 'count',
            ],
            [
                'name' => 'Knowledge Seeker',
                'description' => 'Complete 50 resources',
                'slug' => 'knowledge-seeker',
                'icon' => '📖',
                'type' => 'resources_completed',
                'requirement_value' => 50,
                'requirement_type' => 'count',
            ],
            [
                'name' => 'Path Starter',
                'description' => 'Start your first learning path',
                'slug' => 'path-starter',
                'icon' => '🎯',
                'type' => 'paths_started',
                'requirement_value' => 1,
                'requirement_type' => 'count',
            ],
            [
                'name' => 'Path Completer',
                'description' => 'Complete a learning path',
                'slug' => 'path-completer',
                'icon' => '🏆',
                'type' => 'paths_completed',
                'requirement_value' => 1,
                'requirement_type' => 'count',
            ],
            [
                'name' => 'Journey Master',
                'description' => 'Complete 3 learning paths',
                'slug' => 'journey-master',
                'icon' => '🚀',
                'type' => 'paths_completed',
                'requirement_value' => 3,
                'requirement_type' => 'count',
            ],
            [
                'name' => 'Quiz Master',
                'description' => 'Score 100% on 3 quizzes',
                'slug' => 'quiz-master',
                'icon' => '🧩',
                'type' => 'perfect_quizzes',
                'requirement_value' => 3,
                'requirement_type' => 'count',
            ],
            [
                'name' => 'Quiz Taker',
                'description' => 'Pass 5 quizzes',
                'slug' => 'quiz-taker',
                'icon' => '💯',
                'type' => 'quizzes_passed',
                'requirement_value' => 5,
                'requirement_type' => 'count',
            ],
            [
                'name' => 'Streak Warrior',
                'description' => '7-day learning streak',
                'slug' => 'streak-warrior',
                'icon' => '🔥',
                'type' => 'streak_days',
                'requirement_value' => 7,
                'requirement_type' => 'days',
            ],
            [
                'name' => 'Monthly Master',
                'description' => '30-day learning streak',
                'slug' => 'monthly-master',
                'icon' => '💎',
                'type' => 'streak_days',
                'requirement_value' => 30,
                'requirement_type' => 'days',
            ],
            [
                'name' => 'MCP Pioneer',
                'description' => 'Explore MCP ecosystem',
                'slug' => 'mcp-pioneer',
                'icon' => '🔌',
                'type' => 'special_mcp',
                'requirement_value' => 1,
                'requirement_type' => 'count',
            ],
            [
                'name' => 'Agent Builder',
                'description' => 'Try 5 AI agent tools',
                'slug' => 'agent-builder',
                'icon' => '🛠️',
                'type' => 'special_agents',
                'requirement_value' => 5,
                'requirement_type' => 'count',
            ],
            [
                'name' => 'Dedicated Learner',
                'description' => 'Earn 1000 points',
                'slug' => 'dedicated-learner',
                'icon' => '⭐',
                'type' => 'points_earned',
                'requirement_value' => 1000,
                'requirement_type' => 'count',
            ],
            [
                'name' => 'Point Collector',
                'description' => 'Earn 5000 points',
                'slug' => 'point-collector',
                'icon' => '💰',
                'type' => 'points_earned',
                'requirement_value' => 5000,
                'requirement_type' => 'count',
            ],
            [
                'name' => 'Claude Code Pro',
                'description' => 'Complete Claude Code Mastery path',
                'slug' => 'claude-code-pro',
                'icon' => '⚡',
                'type' => 'special_path',
                'requirement_value' => 1,
                'requirement_type' => 'count',
            ],
            [
                'name' => 'AI Engineer',
                'description' => 'Complete AI Engineer Path',
                'slug' => 'ai-engineer-badge',
                'icon' => '🤖',
                'type' => 'special_path',
                'requirement_value' => 1,
                'requirement_type' => 'count',
            ],
        ];

        foreach ($badges as $badge) {
            Badge::updateOrCreate(['slug' => $badge['slug']], $badge);
        }
    }
}
