<?php

namespace Database\Seeders;

use App\Models\LearningQuest;
use App\Models\Quiz;
use App\Models\Resource;
use Illuminate\Database\Seeder;

class LearningQuestSeeder extends Seeder
{
    public function run(): void
    {
        $quests = [
            // Day 1 - Getting Started
            [
                'title' => 'Meet Claude Code',
                'description' => 'Start your first conversation with Claude Code. It\'s like having a smart friend who helps you code!',
                'type' => 'play',
                'order' => 1,
                'xp_reward' => 25,
            ],
            [
                'title' => 'Read about Claude',
                'description' => 'Learn what Claude Code can do. Discover your new coding buddy!',
                'type' => 'read',
                'order' => 2,
                'xp_reward' => 20,
            ],
            [
                'title' => 'Write your first prompt',
                'description' => 'Write a simple prompt asking Claude to help you. Try: "Help me create a hello world program"',
                'type' => 'write',
                'order' => 3,
                'xp_reward' => 30,
            ],

            // Day 2 - Basics
            [
                'title' => 'Explore the CLI',
                'description' => 'Play around with Claude Code commands. Try asking it to read a file!',
                'type' => 'play',
                'order' => 4,
                'xp_reward' => 25,
            ],
            [
                'title' => 'Learn about CLAUDE.md',
                'description' => 'Read how to teach Claude about your project. It\'s like giving it a tour of your code!',
                'type' => 'read',
                'order' => 5,
                'xp_reward' => 20,
            ],
            [
                'title' => 'Create CLAUDE.md',
                'description' => 'Create your first CLAUDE.md file. Tell Claude about yourself and what you like!',
                'type' => 'write',
                'order' => 6,
                'xp_reward' => 35,
            ],

            // Day 3 - Working with Files
            [
                'title' => 'Ask Claude to create a file',
                'description' => 'Play! Ask Claude to create a simple file for you. Watch magic happen!',
                'type' => 'play',
                'order' => 7,
                'xp_reward' => 25,
            ],
            [
                'title' => 'Read about tool use',
                'description' => 'Learn how Claude uses tools to do real work - not just talk!',
                'type' => 'read',
                'order' => 8,
                'xp_reward' => 20,
            ],
            [
                'title' => 'Edit a file with Claude',
                'description' => 'Practice! Ask Claude to make a small change to a file. Maybe add a comment?',
                'type' => 'write',
                'order' => 9,
                'xp_reward' => 30,
            ],

            // Day 4 - Running Code
            [
                'title' => 'Watch Claude run code',
                'description' => 'Play! Ask Claude to run some code. See what happens when AI actually runs your code!',
                'type' => 'play',
                'order' => 10,
                'xp_reward' => 25,
            ],
            [
                'title' => 'Read about git integration',
                'description' => 'Learn how Claude works with Git. It\'s like having a co-pilot for version control!',
                'type' => 'read',
                'order' => 11,
                'xp_reward' => 20,
            ],
            [
                'title' => 'Commit with Claude',
                'description' => 'Practice! Ask Claude to help you commit your changes. Watch it write a great commit message!',
                'type' => 'write',
                'order' => 12,
                'xp_reward' => 35,
            ],

            // Day 5 - MCP & Agents
            [
                'title' => 'Explore MCP',
                'description' => 'Play! Learn what MCP is - it\'s like giving Claude superpowers to connect to other tools!',
                'type' => 'play',
                'order' => 13,
                'xp_reward' => 30,
            ],
            [
                'title' => 'Read about agents',
                'description' => 'Learn what AI agents are. They can think and act on their own!',
                'type' => 'read',
                'order' => 14,
                'xp_reward' => 25,
            ],
            [
                'title' => 'Write your first agent prompt',
                'description' => 'Practice! Write a prompt that tells Claude to do multiple steps on its own.',
                'type' => 'write',
                'order' => 15,
                'xp_reward' => 40,
            ],

            // Day 6 - Quiz Time
            [
                'title' => 'Take a quiz!',
                'description' => 'Play! Test what you\'ve learned. Quizzes are fun and you get points!',
                'type' => 'play',
                'order' => 16,
                'xp_reward' => 50,
            ],
            [
                'title' => 'Review your notes',
                'description' => 'Read through what you\'ve learned. Reviewing helps you remember!',
                'type' => 'read',
                'order' => 17,
                'xp_reward' => 15,
            ],
            [
                'title' => 'Teach someone else',
                'description' => 'Write! Explain what you learned to a friend (or pretend!). Teaching is the best way to learn!',
                'type' => 'write',
                'order' => 18,
                'xp_reward' => 50,
            ],
        ];

        foreach ($quests as $questData) {
            LearningQuest::updateOrCreate(
                ['title' => $questData['title']],
                $questData
            );
        }

        // Link some quests to resources
        $resources = [
            'Claude Code Quickstart' => 1,
            'Claude Code Overview' => 2,
            'CLAUDE.md & Memory System' => 5,
            'Claude API — Tool Use' => 8,
            'Model Context Protocol (MCP)' => 13,
            'Claude Agent SDK — Overview' => 14,
        ];

        foreach ($resources as $title => $questOrder) {
            $resource = Resource::where('title', 'like', "%{$title}%")->first();
            if ($resource) {
                LearningQuest::where('order', $questOrder)->update(['resource_id' => $resource->id]);
            }
        }
    }
}
