<?php

namespace Database\Seeders;

use App\Models\LearningPath;
use App\Models\PathStep;
use App\Models\Resource;
use Illuminate\Database\Seeder;

class LearningPathSeeder extends Seeder
{
    public function run(): void
    {
        $paths = [
            // === EXISTING PATHS ===
            [
                'title' => 'Claude Code Mastery',
                'description' => 'Go from beginner to Claude Code power user. Master the command line tool that brings AI assistance to your terminal.',
                'slug' => 'claude-code-mastery',
                'icon' => '⚡',
                'difficulty' => 'beginner',
                'estimated_hours' => 20,
                'order' => 1,
                'steps' => [
                    'Claude Code Quickstart',
                    'Claude Code Overview',
                    'CLAUDE.md & Memory System',
                    'Claude Code Best Practices',
                    'Claude Code Best Practices Repo',
                    'Official MCP Servers',
                    'Awesome MCP Servers',
                    'Claude Code GitHub Action',
                ],
            ],
            [
                'title' => 'AI Engineer Path',
                'description' => 'Build production-ready AI applications. Learn prompt engineering, agents, RAG, and deployment.',
                'slug' => 'ai-engineer',
                'icon' => '🤖',
                'difficulty' => 'intermediate',
                'estimated_hours' => 40,
                'order' => 2,
                'steps' => [
                    'Prompt Engineering Interactive Tutorial',
                    'Anthropic Courses',
                    'Agentic AI with Andrew Ng',
                    'AI Agents for Beginners',
                    'LangGraph',
                    'LlamaIndex',
                    'LangChain',
                    'BentoML',
                    'Langfuse',
                ],
            ],
            [
                'title' => 'ML Foundations',
                'description' => 'Core machine learning from scratch. Build strong foundations in mathematics, statistics, and deep learning.',
                'slug' => 'ml-foundations',
                'icon' => '📊',
                'difficulty' => 'intermediate',
                'estimated_hours' => 80,
                'order' => 3,
                'steps' => [
                    'CS50 - Harvard',
                    'Mathematics for Machine Learning',
                    'Stanford CS229: Machine Learning',
                    'MIT 6.S191: Intro to Deep Learning',
                    'Developing Large Language Models',
                    'Reinforcement Learning in Python',
                    'Understanding Machine Learning',
                    'Hands-On ML with Scikit-Learn, Keras & TensorFlow',
                ],
            ],
            [
                'title' => 'Autonomous Coding Agent',
                'description' => 'Build AI agents that code autonomously. Master multi-agent systems, MCP, and autonomous coding tools.',
                'slug' => 'autonomous-coding-agent',
                'icon' => '🚀',
                'difficulty' => 'advanced',
                'estimated_hours' => 30,
                'order' => 4,
                'steps' => [
                    'AI Agents for Beginners',
                    'Agentic AI with Andrew Ng',
                    'Google AI Agents Intensive',
                    'CrewAI',
                    'AutoGen',
                    'OpenHands',
                    'Continue',
                    'Official MCP Servers',
                    'Awesome Claude Code',
                ],
            ],
            [
                'title' => 'Deep Learning Expert',
                'description' => 'Master deep learning from neural networks to transformers. Covers PyTorch, JAX, and advanced architectures.',
                'slug' => 'deep-learning-expert',
                'icon' => '🧠',
                'difficulty' => 'advanced',
                'estimated_hours' => 60,
                'order' => 5,
                'steps' => [
                    'MIT 6.S191: Intro to Deep Learning',
                    'Fast.ai Practical Deep Learning',
                    'PyTorch',
                    'Hugging Face Transformers',
                    'JAX',
                    'Stanford CS224N: NLP with Deep Learning',
                    'Transformer Architecture Deep Dive',
                    'Deep Learning (Goodfellow)',
                ],
            ],
            [
                'title' => 'RAG & Vector Search Specialist',
                'description' => 'Build powerful RAG applications. Master embeddings, vector databases, and retrieval systems.',
                'slug' => 'rag-vector-search',
                'icon' => '🔍',
                'difficulty' => 'intermediate',
                'estimated_hours' => 25,
                'order' => 6,
                'steps' => [
                    'LangChain',
                    'LlamaIndex',
                    'Chroma',
                    'Qdrant',
                    'GraphRAG',
                    'Anthropic Courses',
                    'Developing Large Language Models',
                ],
            ],
            [
                'title' => 'LLM Fine-Tuning Expert',
                'description' => 'Customize AI models for your needs. Learn LoRA, QLoRA, RLHF, and efficient fine-tuning techniques.',
                'slug' => 'llm-fine-tuning',
                'icon' => '🎛️',
                'difficulty' => 'advanced',
                'estimated_hours' => 35,
                'order' => 7,
                'steps' => [
                    'PEFT',
                    'TRL',
                    'Unsloth',
                    'LLaMA-Factory',
                    'Reinforcement Learning in Python',
                    'Stanford CS229: Machine Learning',
                    'Deep Learning (Goodfellow)',
                ],
            ],
            [
                'title' => 'AI-Powered Developer',
                'description' => 'Supercharge your development workflow with AI coding assistants and Claude Code mastery.',
                'slug' => 'ai-powered-developer',
                'icon' => '⌨️',
                'difficulty' => 'beginner',
                'estimated_hours' => 15,
                'order' => 8,
                'steps' => [
                    'Claude Code Quickstart',
                    'Claude Code: Agentic Coding Assistant',
                    'Claude Code Best Practices',
                    'Continue',
                    'Aider',
                    'Opencode',
                    'Awesome Claude Code',
                ],
            ],

            // === NEW LEARNING PATHS ===

            // 9. Computer Vision
            [
                'title' => 'Computer Vision Engineer',
                'description' => 'Build vision systems from image classification to object detection. Learn CNNs, vision transformers, and real-world applications.',
                'slug' => 'computer-vision-engineer',
                'icon' => '👁️',
                'difficulty' => 'intermediate',
                'estimated_hours' => 50,
                'order' => 9,
                'steps' => [
                    'MIT 6.S191: Intro to Deep Learning',
                    'Fast.ai Practical Deep Learning',
                    'PyTorch',
                    'Hands-On ML with Scikit-Learn, Keras & TensorFlow',
                    'Stanford CS224N: NLP with Deep Learning',
                    'Deep Learning (Goodfellow)',
                ],
            ],

            // 10. NLP Specialist
            [
                'title' => 'NLP Specialist',
                'description' => 'Master natural language processing from text preprocessing to transformer models. Build chatbots, sentiment analyzers, and more.',
                'slug' => 'nlp-specialist',
                'icon' => '💬',
                'difficulty' => 'intermediate',
                'estimated_hours' => 45,
                'order' => 10,
                'steps' => [
                    'Stanford CS224N: NLP with Deep Learning',
                    'MIT 6.S191: Intro to Deep Learning',
                    'PyTorch',
                    'Hugging Face Transformers',
                    'Developing Large Language Models',
                    'Hands-On ML with Scikit-Learn, Keras & TensorFlow',
                ],
            ],

            // 11. Google Cloud AI
            [
                'title' => 'Google Cloud AI Practitioner',
                'description' => 'Master Google\'s AI tools and cloud services. Learn Vertex AI, Gemini, and enterprise ML deployment.',
                'slug' => 'google-cloud-ai',
                'icon' => '☁️',
                'difficulty' => 'intermediate',
                'estimated_hours' => 30,
                'order' => 11,
                'steps' => [
                    'Google AI Essentials',
                    'Introduction to Vertex AI Studio',
                    'Google AI Agents Intensive',
                    'MLOps Concepts',
                    'BentoML',
                ],
            ],

            // 12. MLOps Engineering
            [
                'title' => 'MLOps Engineering',
                'description' => 'Bridge ML development and production. Master CI/CD for ML, monitoring, and scalable deployment.',
                'slug' => 'mlops-engineering',
                'icon' => '🔄',
                'difficulty' => 'advanced',
                'estimated_hours' => 40,
                'order' => 12,
                'steps' => [
                    'MLOps Concepts',
                    'MLflow',
                    'Langfuse',
                    'BentoML',
                    'Developing Large Language Models',
                    'Stanford CS229: Machine Learning',
                ],
            ],

            // 13. AI Product Manager
            [
                'title' => 'AI Product Manager',
                'description' => 'Lead AI product development from ideation to launch. Understand AI capabilities, limitations, and business value.',
                'slug' => 'ai-product-manager',
                'icon' => '📦',
                'difficulty' => 'intermediate',
                'estimated_hours' => 25,
                'order' => 13,
                'steps' => [
                    'Google AI Essentials',
                    'Prompt Engineering Interactive Tutorial',
                    'Agentic AI with Andrew Ng',
                    'AI Agents for Beginners',
                    'MLOps Concepts',
                ],
            ],

            // 14. Prompt Engineering Professional
            [
                'title' => 'Prompt Engineering Professional',
                'description' => 'Become a prompt engineering expert. Master advanced techniques, system prompts, and AI interaction patterns.',
                'slug' => 'prompt-engineering-professional',
                'icon' => '💡',
                'difficulty' => 'beginner',
                'estimated_hours' => 20,
                'order' => 14,
                'steps' => [
                    'Prompt Engineering Interactive Tutorial',
                    'Anthropic Courses',
                    'Claude Cookbooks',
                    'Google AI Essentials',
                    'Claude Code Best Practices',
                ],
            ],

            // 15. Local AI Deployment
            [
                'title' => 'Local AI Deployment',
                'description' => 'Run AI models on your own hardware. Master Ollama, vLLM, llama.cpp, and privacy-focused AI deployment.',
                'slug' => 'local-ai-deployment',
                'icon' => '🖥️',
                'difficulty' => 'intermediate',
                'estimated_hours' => 25,
                'order' => 15,
                'steps' => [
                    'Ollama',
                    'llama.cpp',
                    'vLLM',
                    'Free LLM API Resources',
                    'PyTorch',
                    'Hugging Face Transformers',
                ],
            ],

            // 16. Multi-Agent Systems Architect
            [
                'title' => 'Multi-Agent Systems Architect',
                'description' => 'Design complex multi-agent AI systems. Learn orchestration, communication protocols, and scalable agent architectures.',
                'slug' => 'multi-agent-systems-architect',
                'icon' => '🌐',
                'difficulty' => 'advanced',
                'estimated_hours' => 45,
                'order' => 16,
                'steps' => [
                    'Agentic AI with Andrew Ng',
                    'AI Agents for Beginners',
                    'Google AI Agents Intensive',
                    'LangGraph',
                    'CrewAI',
                    'AutoGen',
                    'Google ADK',
                ],
            ],

            // 17. AI Research Scientist
            [
                'title' => 'AI Research Scientist',
                'description' => 'Pursue cutting-edge AI research. Master fundamentals, read papers, and contribute to open source.',
                'slug' => 'ai-research-scientist',
                'icon' => '🔬',
                'difficulty' => 'advanced',
                'estimated_hours' => 100,
                'order' => 17,
                'steps' => [
                    'CS50 - Harvard',
                    'Mathematics for Machine Learning',
                    'Stanford CS229: Machine Learning',
                    'MIT 6.S191: Intro to Deep Learning',
                    'Stanford CS224N: NLP with Deep Learning',
                    'Deep Learning (Goodfellow)',
                    'Understanding Machine Learning',
                    'Reinforcement Learning in Python',
                ],
            ],

            // 18. Generative AI Creative
            [
                'title' => 'Generative AI Creative',
                'description' => 'Create art, music, and content with AI. Master diffusion models, image generation, and creative applications.',
                'slug' => 'generative-ai-creative',
                'icon' => '🎨',
                'difficulty' => 'intermediate',
                'estimated_hours' => 35,
                'order' => 18,
                'steps' => [
                    'MIT 6.S191: Intro to Deep Learning',
                    'Fast.ai Practical Deep Learning',
                    'PyTorch',
                    'Hugging Face Transformers',
                    'Anthropic Courses',
                ],
            ],

            // 19. Production LLM Applications
            [
                'title' => 'Production LLM Applications',
                'description' => 'Build and deploy LLM-powered applications at scale. Cover architecture, optimization, and best practices.',
                'slug' => 'production-llm-applications',
                'icon' => '🏭',
                'difficulty' => 'advanced',
                'estimated_hours' => 50,
                'order' => 19,
                'steps' => [
                    'Anthropic Courses',
                    'Developing Large Language Models',
                    'LangChain',
                    'LlamaIndex',
                    'LangGraph',
                    'BentoML',
                    'Langfuse',
                    'vLLM',
                ],
            ],

            // 20. AI Security & Safety
            [
                'title' => 'AI Security & Safety Engineer',
                'description' => 'Build secure and safe AI systems. Learn about adversarial attacks, red teaming, and responsible AI development.',
                'slug' => 'ai-security-safety',
                'icon' => '🛡️',
                'difficulty' => 'advanced',
                'estimated_hours' => 40,
                'order' => 20,
                'steps' => [
                    'Anthropic Courses',
                    'Prompt Engineering Interactive Tutorial',
                    'Stanford CS229: Machine Learning',
                    'Deep Learning (Goodfellow)',
                    'Developing Large Language Models',
                ],
            ],

            // 21. Data Engineering for AI
            [
                'title' => 'Data Engineering for AI',
                'description' => 'Build data pipelines for machine learning. Master data processing, feature stores, and MLOps data management.',
                'slug' => 'data-engineering-ai',
                'icon' => '🗄️',
                'difficulty' => 'intermediate',
                'estimated_hours' => 35,
                'order' => 21,
                'steps' => [
                    'CS50 - Harvard',
                    'Hands-On ML with Scikit-Learn, Keras & TensorFlow',
                    'MLOps Concepts',
                    'MLflow',
                    'Langfuse',
                ],
            ],

            // 22. Conversational AI Developer
            [
                'title' => 'Conversational AI Developer',
                'description' => 'Build chatbots and conversational interfaces. Master dialogue systems, context management, and voice AI.',
                'slug' => 'conversational-ai-developer',
                'icon' => '🎙️',
                'difficulty' => 'intermediate',
                'estimated_hours' => 40,
                'order' => 22,
                'steps' => [
                    'Stanford CS224N: NLP with Deep Learning',
                    'Hugging Face Transformers',
                    'LangChain',
                    'Agentic AI with Andrew Ng',
                    'Developing Large Language Models',
                    'Anthropic Courses',
                ],
            ],

            // 23. Autonomous Systems Developer
            [
                'title' => 'Autonomous Systems Developer',
                'description' => 'Build self-directed AI systems. Master reinforcement learning, decision making, and autonomous agents.',
                'slug' => 'autonomous-systems-developer',
                'icon' => '🤖',
                'difficulty' => 'advanced',
                'estimated_hours' => 55,
                'order' => 23,
                'steps' => [
                    'Reinforcement Learning in Python',
                    'Stanford CS229: Machine Learning',
                    'MIT 6.S191: Intro to Deep Learning',
                    'Deep Learning (Goodfellow)',
                    'Understanding Machine Learning',
                    'Agentic AI with Andrew Ng',
                ],
            ],

            // 24. YouTube AI Content Creator
            [
                'title' => 'AI Educator & Content Creator',
                'description' => 'Learn AI concepts deeply and create educational content. Perfect for tutorials, courses, and technical writing.',
                'slug' => 'ai-educator-content-creator',
                'icon' => '📚',
                'difficulty' => 'intermediate',
                'estimated_hours' => 30,
                'order' => 24,
                'steps' => [
                    'Google AI Essentials',
                    'MIT 6.S191: Intro to Deep Learning',
                    'Andrej Karpathy',
                    'StatQuest with Josh Starmer',
                    '3Blue1Brown',
                    'Machine Learning Yearning',
                ],
            ],

            // 25. Full-Stack AI Developer
            [
                'title' => 'Full-Stack AI Developer',
                'description' => 'Build complete AI-powered applications end-to-end. From model training to user-facing web and mobile apps.',
                'slug' => 'full-stack-ai-developer',
                'icon' => '🛠️',
                'difficulty' => 'intermediate',
                'estimated_hours' => 60,
                'order' => 25,
                'steps' => [
                    'CS50 - Harvard',
                    'Prompt Engineering Interactive Tutorial',
                    'Claude Code Quickstart',
                    'LangChain',
                    'BentoML',
                    'MLOps Concepts',
                    'Google AI Essentials',
                    'Hands-On ML with Scikit-Learn, Keras & TensorFlow',
                ],
            ],

            // === NEW PATHS FOR ADDED RESOURCES ===
            [
                'title' => 'Claude API Fundamentals',
                'description' => 'Learn to integrate Claude API into your applications. Master messages, tool use, and batch processing.',
                'slug' => 'claude-api-fundamentals',
                'icon' => '🔌',
                'difficulty' => 'beginner',
                'estimated_hours' => 8,
                'order' => 6,
                'steps' => [
                    'Claude API — Messages',
                    'Claude API — Tool Use',
                    'Claude API — Message Batches',
                ],
            ],
            [
                'title' => 'Claude Agent SDK Mastery',
                'description' => 'Build autonomous agents with Claude Agent SDK. Learn hooks, subagents, and session management.',
                'slug' => 'claude-agent-sdk',
                'icon' => '🧩',
                'difficulty' => 'intermediate',
                'estimated_hours' => 12,
                'order' => 7,
                'steps' => [
                    'Claude Agent SDK — Overview',
                    'Claude Agent SDK — Hooks',
                    'Claude Agent SDK — Subagents',
                    'Claude Agent SDK — Sessions',
                ],
            ],
            [
                'title' => 'MCP Developer',
                'description' => 'Master the Model Context Protocol. Build MCP servers and connect Claude to any tool or data source.',
                'slug' => 'mcp-developer',
                'icon' => '🔗',
                'difficulty' => 'intermediate',
                'estimated_hours' => 10,
                'order' => 8,
                'steps' => [
                    'Model Context Protocol (MCP)',
                    'MCP — Tools',
                    'MCP — Resources',
                    'MCP — Servers',
                ],
            ],
            [
                'title' => 'Prompt Engineering Pro',
                'description' => 'Master advanced prompt engineering techniques. Learn extended thinking and build production prompts.',
                'slug' => 'prompt-engineering-pro',
                'icon' => '✏️',
                'difficulty' => 'beginner',
                'estimated_hours' => 6,
                'order' => 9,
                'steps' => [
                    'Prompt Engineering Guide',
                    'Extended Thinking',
                    'Anthropic Cookbook',
                ],
            ],
            [
                'title' => 'Claude Certified Architect',
                'description' => 'Build production-grade AI systems following enterprise best practices. Security, compliance, and scaling.',
                'slug' => 'claude-certified-architect',
                'icon' => '🎓',
                'difficulty' => 'advanced',
                'estimated_hours' => 15,
                'order' => 10,
                'steps' => [
                    'Claude API — Messages',
                    'Claude API — Tool Use',
                    'Claude Agent SDK — Overview',
                    'Claude Agent SDK — Hooks',
                    'Model Context Protocol (MCP)',
                    'MCP — Servers',
                    'Claude Code — GitHub Actions CI/CD',
                    'Claude Certified Architect Guide',
                ],
            ],
        ];

        foreach ($paths as $pathData) {
            $steps = $pathData['steps'];
            unset($pathData['steps']);

            $path = LearningPath::updateOrCreate(
                ['slug' => $pathData['slug']],
                $pathData
            );

            PathStep::where('learning_path_id', $path->id)->delete();

            foreach ($steps as $order => $resourceTitle) {
                $resource = Resource::where('title', $resourceTitle)->first();

                if ($resource) {
                    PathStep::create([
                        'learning_path_id' => $path->id,
                        'resource_id' => $resource->id,
                        'order' => $order,
                        'title' => $resourceTitle,
                    ]);
                }
            }
        }
    }
}
