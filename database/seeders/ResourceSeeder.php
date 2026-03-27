<?php

namespace Database\Seeders;

use App\Models\Resource;
use Illuminate\Database\Seeder;

class ResourceSeeder extends Seeder
{
    public function run(): void
    {
        $resources = [
            // Claude Code - Awesome Lists
            [
                'title' => 'Awesome Claude Code',
                'description' => 'The definitive curated collection (21k+ stars) of Claude Code skills, hooks, slash-commands, agents, plugins, MCP servers, CLI tools, and workflows.',
                'learning_reason' => 'Having a single reference of battle-tested plugins, hooks, and workflows saves hours of trial-and-error. You\'ll discover community-proven patterns that immediately boost your AI-assisted development speed.',
                'category' => 'Claude Code', 'type' => 'GitHub', 'url' => 'https://github.com/hesreallyhim/awesome-claude-code', 'duration_minutes' => 30, 'difficulty_level' => 1, 'icon' => '⭐',
            ],
            [
                'title' => 'Awesome Claude Code Toolkit',
                'description' => 'Massive collection featuring 135 agents, 35 skills, 42 commands, and 150+ plugins for Claude Code power users.',
                'learning_reason' => 'Power users automate repetitive coding tasks with agents and custom commands. This toolkit shows you how to build a personal development environment that multiplies your productivity.',
                'category' => 'Claude Code', 'type' => 'GitHub', 'url' => 'https://github.com/rohitg00/awesome-claude-code-toolkit', 'duration_minutes' => 45, 'difficulty_level' => 2, 'icon' => '🛠️',
            ],

            // Claude Code - Official Docs
            [
                'title' => 'Claude Code Overview',
                'description' => 'Official documentation hub covering everything from quickstart to advanced features.',
                'learning_reason' => 'Understanding the official documentation is the fastest way to learn any tool correctly. You\'ll grasp the full capability set and avoid building workarounds for features that already exist.',
                'category' => 'Claude Code', 'type' => 'Docs', 'url' => 'https://code.claude.com/docs/en/overview', 'duration_minutes' => 20, 'difficulty_level' => 1, 'icon' => '📚',
            ],
            [
                'title' => 'Claude Code Best Practices',
                'description' => 'Official best practices covering context management, CLAUDE.md setup, and multi-agent orchestration.',
                'learning_reason' => 'Without proper context management, AI assistants produce generic output. Mastering these best practices ensures Claude Code understands your codebase deeply and produces project-specific, high-quality code.',
                'category' => 'Claude Code', 'type' => 'Docs', 'url' => 'https://code.claude.com/docs/en/best-practices', 'duration_minutes' => 30, 'difficulty_level' => 2, 'icon' => '📚',
            ],
            [
                'title' => 'CLAUDE.md & Memory System',
                'description' => 'How to control context with CLAUDE.md files — set coding standards and workflow rules.',
                'learning_reason' => 'CLAUDE.md files act as persistent instructions that shape every interaction. Learning this system lets you enforce team coding standards, architectural decisions, and project conventions automatically.',
                'category' => 'Claude Code', 'type' => 'Docs', 'url' => 'https://code.claude.com/docs/en/memory', 'duration_minutes' => 25, 'difficulty_level' => 2, 'icon' => '📚',
            ],
            [
                'title' => 'CLI Reference',
                'description' => 'Complete official reference for the Claude Code command-line interface.',
                'learning_reason' => 'The CLI is where you interact with Claude Code daily. Knowing every flag and option means you can tailor each session — from headless CI runs to interactive pair programming.',
                'category' => 'Claude Code', 'type' => 'Docs', 'url' => 'https://code.claude.com/docs/en/cli-reference', 'duration_minutes' => 15, 'difficulty_level' => 1, 'icon' => '📚',
            ],
            [
                'title' => 'Sub-agents Documentation',
                'description' => 'Official guide to Claude Code sub-agents for parallel tasks.',
                'learning_reason' => 'Sub-agents let you parallelize complex work — run tests, lint code, and refactor simultaneously. This is essential for handling large-scale tasks that would otherwise block your workflow.',
                'category' => 'Claude Code', 'type' => 'Docs', 'url' => 'https://code.claude.com/docs/en/sub-agents', 'duration_minutes' => 20, 'difficulty_level' => 2, 'icon' => '📚',
            ],

            // Claude Code - Learn
            [
                'title' => 'Claude Code: Agentic Coding Assistant',
                'description' => 'Free course by Anthropic & Andrew Ng covering Git worktrees, sub-agent orchestration, and MCP servers.',
                'learning_reason' => 'This course bridges theory and practice with real-world workflows. You\'ll learn agentic patterns — worktrees for parallel branches, MCP servers for external tools — that transform how you ship code.',
                'category' => 'Claude Code', 'type' => 'Course', 'url' => 'https://learn.deeplearning.ai/courses/claude-code-a-highly-agentic-coding-assistant/', 'duration_minutes' => 120, 'difficulty_level' => 2, 'icon' => '🎓',
            ],
            [
                'title' => 'Claude Code Quickstart',
                'description' => 'Official step-by-step getting started guide.',
                'learning_reason' => 'Getting the initial setup right prevents frustration. This quickstart ensures your environment is properly configured so you can focus on building, not debugging your tooling.',
                'category' => 'Claude Code', 'type' => 'Docs', 'url' => 'https://code.claude.com/docs/en/quickstart', 'duration_minutes' => 15, 'difficulty_level' => 1, 'icon' => '🎓',
            ],

            // Claude Code - Patterns
            [
                'title' => 'Claude Code Best Practices Repo',
                'description' => 'Real-world prompt patterns, automation workflows, and configuration examples.',
                'learning_reason' => 'Real-world patterns from practitioners show you what actually works in production. You\'ll adopt proven prompt templates and automation setups instead of reinventing them.',
                'category' => 'Claude Code', 'type' => 'GitHub', 'url' => 'https://github.com/awattar/claude-code-best-practices', 'duration_minutes' => 30, 'difficulty_level' => 2, 'icon' => '🔧',
            ],
            [
                'title' => 'Command-to-Agent-to-Skill Architecture',
                'description' => 'Reference implementation for Claude Code configuration patterns.',
                'learning_reason' => 'Understanding the command-agent-skill hierarchy lets you build composable AI workflows. This architecture pattern is key to scaling from simple prompts to complex automated pipelines.',
                'category' => 'Claude Code', 'type' => 'GitHub', 'url' => 'https://github.com/shanraisshan/claude-code-best-practice', 'duration_minutes' => 25, 'difficulty_level' => 2, 'icon' => '🔧',
            ],

            // Claude Code - Ecosystem
            [
                'title' => 'Official MCP Servers',
                'description' => 'Reference implementations of Model Context Protocol servers.',
                'learning_reason' => 'MCP servers extend Claude Code\'s reach to databases, APIs, and external tools. Understanding reference implementations lets you build custom integrations tailored to your tech stack.',
                'category' => 'Claude Code', 'type' => 'GitHub', 'url' => 'https://github.com/modelcontextprotocol/servers', 'duration_minutes' => 30, 'difficulty_level' => 2, 'icon' => '🌐',
            ],
            [
                'title' => 'Claude Code GitHub Action',
                'description' => 'Official GitHub Action for CI/CD — Claude responds to mentions and reviews PRs.',
                'learning_reason' => 'Integrating Claude into your CI/CD pipeline means automated code reviews, PR feedback, and issue triage. This reduces review bottlenecks and catches issues before human reviewers see them.',
                'category' => 'Claude Code', 'type' => 'GitHub', 'url' => 'https://github.com/anthropics/claude-code-action', 'duration_minutes' => 20, 'difficulty_level' => 2, 'icon' => '🌐',
            ],
            [
                'title' => 'GitHub MCP Server',
                'description' => 'GitHub\'s official MCP server for repo, issues, and PR access.',
                'learning_reason' => 'Direct GitHub integration means Claude Code can read your repos, create issues, and manage PRs without leaving your terminal. This streamlines the entire development lifecycle.',
                'category' => 'Claude Code', 'type' => 'GitHub', 'url' => 'https://github.com/github/github-mcp-server', 'duration_minutes' => 20, 'difficulty_level' => 2, 'icon' => '🌐',
            ],
            [
                'title' => 'Awesome MCP Servers',
                'description' => 'Curated list of MCP servers — Playwright, Figma, databases, and more.',
                'learning_reason' => 'The MCP ecosystem is growing fast. Knowing what\'s available — from browser automation to design tool integration — helps you pick the right servers for your project\'s needs.',
                'category' => 'Claude Code', 'type' => 'GitHub', 'url' => 'https://github.com/wong2/awesome-mcp-servers', 'duration_minutes' => 25, 'difficulty_level' => 2, 'icon' => '🌐',
            ],

            // Prompt Engineering
            [
                'title' => 'Prompt Engineering Interactive Tutorial',
                'description' => 'Hands-on tutorial covering prompt structure, chain-of-thought, and few-shot examples.',
                'learning_reason' => 'Prompt engineering is the single most impactful skill for working with AI. A well-structured prompt can turn a mediocre output into production-ready code. This tutorial builds that skill hands-on.',
                'category' => 'Prompt Engineering', 'type' => 'GitHub', 'url' => 'https://github.com/anthropics/prompt-eng-interactive-tutorial', 'duration_minutes' => 60, 'difficulty_level' => 1, 'icon' => '💡',
            ],
            [
                'title' => 'Anthropic Courses',
                'description' => 'Official courses covering Claude API usage, prompt engineering, and tool use.',
                'learning_reason' => 'Learning directly from the model creators gives you insider understanding of how Claude thinks and responds. You\'ll write prompts that leverage Claude\'s strengths and avoid its limitations.',
                'category' => 'Prompt Engineering', 'type' => 'GitHub', 'url' => 'https://github.com/anthropics/courses', 'duration_minutes' => 120, 'difficulty_level' => 2, 'icon' => '💡',
            ],
            [
                'title' => 'Claude Cookbooks',
                'description' => 'Ready-to-run Jupyter notebooks demonstrating real-world patterns.',
                'learning_reason' => 'Cookbooks provide copy-paste-ready patterns for common tasks — summarization, extraction, classification. They accelerate your development by giving you working starting points.',
                'category' => 'Prompt Engineering', 'type' => 'GitHub', 'url' => 'https://github.com/anthropics/claude-cookbooks', 'duration_minutes' => 90, 'difficulty_level' => 2, 'icon' => '💡',
            ],

            // AI Agents
            [
                'title' => 'Agentic AI with Andrew Ng',
                'description' => 'Build agentic AI systems with iterative, multi-step workflows.',
                'learning_reason' => 'Agentic AI is the next evolution beyond simple chat. Learning to build systems that plan, execute, and iterate autonomously is essential for creating AI that solves real-world problems end-to-end.',
                'category' => 'AI Agents', 'type' => 'Course', 'url' => 'https://www.deeplearning.ai/courses/agentic-ai', 'duration_minutes' => 180, 'difficulty_level' => 2, 'icon' => '🤖',
            ],
            [
                'title' => 'AI Agents for Beginners',
                'description' => 'Free comprehensive course with 12+ lessons covering AI agent fundamentals.',
                'learning_reason' => 'Understanding agent fundamentals — memory, planning, tool use — gives you the vocabulary and mental models to design intelligent systems. This is the foundation every AI engineer needs.',
                'category' => 'AI Agents', 'type' => 'Course', 'url' => 'https://microsoft.github.io/ai-agents-for-beginners/', 'duration_minutes' => 240, 'difficulty_level' => 2, 'icon' => '🤖',
            ],
            [
                'title' => 'Google AI Agents Intensive',
                'description' => '5-Day AI Agents Intensive Course covering hands-on training.',
                'learning_reason' => 'Google\'s intensive format gives you a concentrated deep-dive into building agents with real tools and APIs. The hands-on approach ensures you can build agents, not just understand the theory.',
                'category' => 'AI Agents', 'type' => 'Video', 'url' => 'https://youtube.com/playlist?list=PLqFaTIg4myu9r7uRoNfbJhHUbLp-1t1YE', 'duration_minutes' => 300, 'difficulty_level' => 2, 'icon' => '🤖',
            ],
            [
                'title' => 'LangGraph',
                'description' => 'Stateful, controllable agent orchestration with cycles and persistence.',
                'learning_reason' => 'Complex agents need state management, branching logic, and persistence. LangGraph solves these problems with a graph-based approach that makes agent workflows debuggable and controllable.',
                'category' => 'AI Agents', 'type' => 'GitHub', 'url' => 'https://github.com/langchain-ai/langgraph', 'duration_minutes' => 60, 'difficulty_level' => 3, 'icon' => '🤖',
            ],
            [
                'title' => 'CrewAI',
                'description' => 'Role-based multi-agent framework for collaborative tasks.',
                'learning_reason' => 'Real-world tasks often require multiple specialized agents working together. CrewAI teaches you to decompose problems into roles and orchestrate collaboration between AI agents.',
                'category' => 'AI Agents', 'type' => 'GitHub', 'url' => 'https://github.com/crewAIInc/crewAI', 'duration_minutes' => 45, 'difficulty_level' => 2, 'icon' => '🤖',
            ],
            [
                'title' => 'AutoGen',
                'description' => 'Flexible multi-agent conversation platform.',
                'learning_reason' => 'AutoGen\'s conversation-based paradigm lets agents debate, verify, and refine each other\'s work. This pattern produces more reliable outputs than single-agent systems.',
                'category' => 'AI Agents', 'type' => 'GitHub', 'url' => 'https://github.com/microsoft/autogen', 'duration_minutes' => 60, 'difficulty_level' => 3, 'icon' => '🤖',
            ],
            [
                'title' => 'Google ADK',
                'description' => 'Google\'s open-source framework for building AI agents.',
                'learning_reason' => 'Google\'s agent framework integrates natively with Gemini and Google Cloud services. Learning it gives you access to Google\'s ecosystem for building production-grade AI agents.',
                'category' => 'AI Agents', 'type' => 'GitHub', 'url' => 'https://github.com/google/adk-python', 'duration_minutes' => 60, 'difficulty_level' => 3, 'icon' => '🤖',
            ],

            // AI Coding
            [
                'title' => 'Continue',
                'description' => 'Open-source coding autopilot for VS Code and JetBrains.',
                'learning_reason' => 'Understanding different AI coding tools helps you choose the right one for each workflow. Continue\'s open-source approach means you can customize it to fit your exact development style.',
                'category' => 'AI Coding', 'type' => 'GitHub', 'url' => 'https://github.com/continuedev/continue', 'duration_minutes' => 20, 'difficulty_level' => 1, 'icon' => '⌨️',
            ],
            [
                'title' => 'Aider',
                'description' => 'Terminal-based AI pair programmer.',
                'learning_reason' => 'Aider pioneered terminal-based AI pair programming with Git-aware edits. Learning it gives you a powerful alternative workflow and insights into how AI-code integration works under the hood.',
                'category' => 'AI Coding', 'type' => 'GitHub', 'url' => 'https://github.com/paul-gauthier/aider', 'duration_minutes' => 25, 'difficulty_level' => 1, 'icon' => '⌨️',
            ],
            [
                'title' => 'OpenHands',
                'description' => 'Full-featured AI software engineer.',
                'learning_reason' => 'OpenHands pushes the boundary of what AI can do autonomously — from writing to deploying code. Studying it reveals the architecture patterns behind fully autonomous AI developers.',
                'category' => 'AI Coding', 'type' => 'GitHub', 'url' => 'https://github.com/All-Hands-AI/OpenHands', 'duration_minutes' => 30, 'difficulty_level' => 2, 'icon' => '⌨️',
            ],
            [
                'title' => 'Opencode',
                'description' => 'Open-source AI coding assistant for the terminal.',
                'learning_reason' => 'Opencode offers a lightweight, terminal-native AI assistant. Learning multiple tools in this space helps you pick the right tool for each project and team context.',
                'category' => 'AI Coding', 'type' => 'GitHub', 'url' => 'https://github.com/different-ai/opencode', 'duration_minutes' => 20, 'difficulty_level' => 1, 'icon' => '⌨️',
            ],

            // ML Foundations
            [
                'title' => 'Stanford CS229: Machine Learning',
                'description' => 'Graduate-level course by Andrew Ng covering supervised/unsupervised learning.',
                'learning_reason' => 'CS229 provides the mathematical foundation that separates ML practitioners from ML engineers. Understanding the theory behind algorithms lets you debug models, tune hyperparameters, and design novel solutions.',
                'category' => 'ML Foundations', 'type' => 'Course', 'url' => 'https://see.stanford.edu/course/cs229', 'duration_minutes' => 1800, 'difficulty_level' => 3, 'icon' => '📊',
            ],
            [
                'title' => 'Stanford CS224N: NLP with Deep Learning',
                'description' => 'NLP course covering word embeddings, RNNs, transformers, and LLMs.',
                'learning_reason' => 'NLP is the core technology behind LLMs. Understanding word embeddings, attention mechanisms, and transformer architecture helps you work more effectively with and build upon language models.',
                'category' => 'ML Foundations', 'type' => 'Video', 'url' => 'https://www.youtube.com/playlist?list=PLoROMvodv4rOaMFbaqxPDoLWjDaRAdP9D', 'duration_minutes' => 1500, 'difficulty_level' => 3, 'icon' => '📊',
            ],

            // Deep Learning
            [
                'title' => 'MIT 6.S191: Intro to Deep Learning',
                'description' => 'MIT\'s introductory deep learning program covering neural networks, CNNs, RNNs, and transformers.',
                'learning_reason' => 'Deep learning drives modern AI — from image recognition to language generation. MIT\'s course builds your intuition for how neural networks learn, which is critical for designing and debugging AI systems.',
                'category' => 'Deep Learning', 'type' => 'Course', 'url' => 'https://www.youtube.com/playlist?list=PLtBw6njQRU-rwp5__7C0oIVt26ZgjG9NI', 'duration_minutes' => 900, 'difficulty_level' => 2, 'icon' => '🧠',
            ],
            [
                'title' => 'Fast.ai Practical Deep Learning',
                'description' => 'Legendary free course teaching deep learning top-down.',
                'learning_reason' => 'Fast.ai\'s top-down approach gets you building working models on day one, then progressively deepens your understanding. This practical-first method is proven to produce capable practitioners faster.',
                'category' => 'Deep Learning', 'type' => 'Course', 'url' => 'https://github.com/fastai/fastai', 'duration_minutes' => 1200, 'difficulty_level' => 2, 'icon' => '🧠',
            ],

            // LLM
            [
                'title' => 'Developing Large Language Models',
                'description' => '16-hour track covering LLM concepts, transformers, and building LLM apps.',
                'learning_reason' => 'LLMs are reshaping every industry. Understanding how they work — tokenization, attention, fine-tuning — lets you build smarter applications and make informed decisions about when and how to use them.',
                'category' => 'LLMs', 'type' => 'Course', 'url' => 'https://www.datacamp.com/tracks/developing-large-language-models', 'duration_minutes' => 960, 'difficulty_level' => 2, 'icon' => '📝',
            ],

            // Reinforcement Learning
            [
                'title' => 'Reinforcement Learning in Python',
                'description' => '12-hour track covering RL fundamentals, DQN, and RLHF.',
                'learning_reason' => 'RL powers everything from game AI to RLHF (the technique that makes ChatGPT helpful). Understanding RL fundamentals is essential for anyone working on AI alignment or decision-making systems.',
                'category' => 'Reinforcement Learning', 'type' => 'Course', 'url' => 'https://www.datacamp.com/tracks/reinforcement-learning', 'duration_minutes' => 720, 'difficulty_level' => 3, 'icon' => '🎮',
            ],

            // MLOps
            [
                'title' => 'MLOps Concepts',
                'description' => '2-hour course on deploying ML models to production.',
                'learning_reason' => 'Most ML projects fail not in modeling but in deployment. MLOps bridges the gap between a working notebook and a reliable production system — versioning, monitoring, and automated retraining.',
                'category' => 'MLOps', 'type' => 'Course', 'url' => 'https://www.datacamp.com/courses/mlops-concepts', 'duration_minutes' => 120, 'difficulty_level' => 2, 'icon' => '🚀',
            ],
            [
                'title' => 'MLflow',
                'description' => 'End-to-end ML lifecycle platform — experiment tracking and model registry.',
                'learning_reason' => 'Without experiment tracking, ML work becomes chaotic. MLflow gives you reproducibility, comparison, and a model registry — essential for teams shipping ML to production.',
                'category' => 'MLOps', 'type' => 'GitHub', 'url' => 'https://github.com/mlflow/mlflow', 'duration_minutes' => 60, 'difficulty_level' => 2, 'icon' => '🚀',
            ],
            [
                'title' => 'Langfuse',
                'description' => 'Open-source LLM observability — trace and debug LLM apps.',
                'learning_reason' => 'LLM applications are notoriously hard to debug. Langfuse gives you tracing, cost tracking, and quality scoring so you can understand why your AI app behaves the way it does.',
                'category' => 'MLOps', 'type' => 'GitHub', 'url' => 'https://github.com/langfuse/langfuse', 'duration_minutes' => 45, 'difficulty_level' => 2, 'icon' => '🚀',
            ],
            [
                'title' => 'BentoML',
                'description' => 'Build and ship AI applications as production-ready APIs.',
                'learning_reason' => 'Turning a model into a scalable API is a critical skill. BentoML standardizes the packaging and serving process, letting you deploy any model with proper batching, scaling, and monitoring.',
                'category' => 'MLOps', 'type' => 'GitHub', 'url' => 'https://github.com/bentoml/BentoML', 'duration_minutes' => 60, 'difficulty_level' => 2, 'icon' => '🚀',
            ],

            // Google AI
            [
                'title' => 'Google AI Essentials',
                'description' => 'Under 5 hours to learn AI fundamentals and prompt engineering.',
                'learning_reason' => 'Google\'s AI Essentials provides a vendor-neutral AI foundation. Understanding core concepts from multiple providers helps you make better technology choices and avoid lock-in.',
                'category' => 'Google AI', 'type' => 'Course', 'url' => 'https://grow.google/ai-essentials/', 'duration_minutes' => 300, 'difficulty_level' => 1, 'icon' => '🔵',
            ],
            [
                'title' => 'Introduction to Vertex AI Studio',
                'description' => 'Free 1.5-hour course on Gemini multimodal applications.',
                'learning_reason' => 'Vertex AI Studio makes multimodal AI accessible — text, images, video in one platform. Learning it opens doors to building rich AI applications that go beyond text-only interactions.',
                'category' => 'Google AI', 'type' => 'Course', 'url' => 'https://www.skills.google/course_templates/552', 'duration_minutes' => 90, 'difficulty_level' => 1, 'icon' => '🔵',
            ],

            // CS Fundamentals
            [
                'title' => 'CS50 - Harvard',
                'description' => 'Harvard\'s legendary introduction to computer science.',
                'learning_reason' => 'CS50 builds the foundational thinking every developer needs — data structures, algorithms, memory management. These fundamentals make you a better engineer regardless of what technology you use.',
                'category' => 'CS Fundamentals', 'type' => 'Course', 'url' => 'https://cs50.harvard.edu/', 'duration_minutes' => 3000, 'difficulty_level' => 1, 'icon' => '💻',
            ],
            [
                'title' => 'Transformer Architecture Deep Dive',
                'description' => 'Advanced Stanford lecture on transformer-based models.',
                'learning_reason' => 'Transformers are the architecture behind GPT, Claude, Gemini, and every modern LLM. Deep understanding of attention mechanisms and positional encoding is essential for advanced AI work.',
                'category' => 'CS Fundamentals', 'type' => 'Video', 'url' => 'https://www.youtube.com/watch?v=yT84Y5zCnaA', 'duration_minutes' => 120, 'difficulty_level' => 3, 'icon' => '💻',
            ],

            // Free Textbooks
            [
                'title' => 'Understanding Machine Learning',
                'description' => 'Comprehensive textbook covering theoretical ML foundations.',
                'learning_reason' => 'Theory gives you the ability to reason about why models work or fail. This textbook\'s rigorous treatment of learning theory helps you design better experiments and avoid common pitfalls.',
                'category' => 'Free Textbooks', 'type' => 'Book', 'url' => 'https://cs.huji.ac.il/~shais/UnderstandingMachineLearning/understanding-machine-learning-theory-algorithms.pdf', 'duration_minutes' => 2400, 'difficulty_level' => 3, 'icon' => '📖',
            ],
            [
                'title' => 'Mathematics for Machine Learning',
                'description' => 'Essential mathematical foundations for ML.',
                'learning_reason' => 'Linear algebra, calculus, and probability are the language of ML. Without this math, you\'re limited to using models as black boxes. With it, you can read papers, debug gradients, and innovate.',
                'category' => 'Free Textbooks', 'type' => 'Book', 'url' => 'https://mml-book.github.io/book/mml-book.pdf', 'duration_minutes' => 2400, 'difficulty_level' => 3, 'icon' => '📖',
            ],
            [
                'title' => 'Deep Learning Principles',
                'description' => 'Structured approach to understanding deep learning.',
                'learning_reason' => 'This book provides the theoretical underpinnings of why deep networks generalize. Understanding these principles helps you design architectures and training procedures with confidence.',
                'category' => 'Free Textbooks', 'type' => 'Book', 'url' => 'https://arxiv.org/pdf/2106.10165', 'duration_minutes' => 1800, 'difficulty_level' => 3, 'icon' => '📖',
            ],
            [
                'title' => 'Deep Learning (Goodfellow)',
                'description' => 'Classic deep learning textbook.',
                'learning_reason' => 'Known as "the deep learning bible," this book covers everything from optimization to generative models. It\'s the reference that researchers and practitioners turn to for definitive explanations.',
                'category' => 'Free Textbooks', 'type' => 'Book', 'url' => 'http://deeplearningbook.org', 'duration_minutes' => 3000, 'difficulty_level' => 3, 'icon' => '📖',
            ],
            [
                'title' => 'Reinforcement Learning: An Introduction',
                'description' => 'Definitive textbook on reinforcement learning by Sutton & Barto.',
                'learning_reason' => 'This is the foundational RL text that every researcher references. Understanding MDPs, temporal difference learning, and policy gradients opens the door to cutting-edge AI research.',
                'category' => 'Free Textbooks', 'type' => 'Book', 'url' => 'https://andrew.cmu.edu/course/10-703/textbook/BartoSutton.pdf', 'duration_minutes' => 3000, 'difficulty_level' => 3, 'icon' => '📖',
            ],
            [
                'title' => 'Machine Learning Systems (CS249r)',
                'description' => 'Open-access book on TinyML and efficient deep learning.',
                'learning_reason' => 'Deploying ML on edge devices and resource-constrained environments is a growing field. This book teaches the systems thinking needed to optimize models for real-world hardware constraints.',
                'category' => 'Free Textbooks', 'type' => 'GitHub', 'url' => 'https://github.com/harvard-edge/cs249r_book', 'duration_minutes' => 1800, 'difficulty_level' => 3, 'icon' => '📖',
            ],

            // YouTube
            [
                'title' => 'Andrej Karpathy',
                'description' => 'Former Tesla AI Director sharing deep dives into neural networks and GPT internals.',
                'learning_reason' => 'Karpathy explains complex AI concepts with rare clarity. His "build from scratch" approach gives you intuition that no textbook can — understanding GPT by coding it character by character.',
                'category' => 'YouTube', 'type' => 'Channel', 'url' => 'https://www.youtube.com/@AndrejKarpathy', 'duration_minutes' => 600, 'difficulty_level' => 2, 'icon' => '▶️',
            ],
            [
                'title' => 'StatQuest with Josh Starmer',
                'description' => 'Statistics and ML concepts explained clearly.',
                'learning_reason' => 'StatQuest makes intimidating statistical concepts approachable. Understanding statistics is non-negotiable for evaluating models, designing experiments, and interpreting results correctly.',
                'category' => 'YouTube', 'type' => 'Channel', 'url' => 'https://www.youtube.com/@statquest', 'duration_minutes' => 600, 'difficulty_level' => 1, 'icon' => '▶️',
            ],
            [
                'title' => '3Blue1Brown',
                'description' => 'Visual explanations of mathematics and neural networks.',
                'learning_reason' => 'Visual intuition accelerates mathematical understanding dramatically. 3Blue1Brown\'s animations make linear algebra, calculus, and neural network concepts click in a way that equations alone cannot.',
                'category' => 'YouTube', 'type' => 'Channel', 'url' => 'https://www.youtube.com/@3blue1brown', 'duration_minutes' => 600, 'difficulty_level' => 1, 'icon' => '▶️',
            ],

            // AI Frameworks
            [
                'title' => 'PyTorch',
                'description' => 'Dominant deep learning framework with dynamic computation graphs.',
                'learning_reason' => 'PyTorch is the industry standard for research and increasingly for production. Its Pythonic API and dynamic graphs make experimentation fast, and it\'s the framework most AI papers use.',
                'category' => 'AI Frameworks', 'type' => 'GitHub', 'url' => 'https://github.com/pytorch/pytorch', 'duration_minutes' => 120, 'difficulty_level' => 3, 'icon' => '🔧',
            ],
            [
                'title' => 'Hugging Face Transformers',
                'description' => 'De facto standard library for pretrained models.',
                'learning_reason' => 'Hugging Face is the npm of AI — thousands of pretrained models ready to use. Learning this library lets you leverage state-of-the-art models for any NLP or vision task in minutes.',
                'category' => 'AI Frameworks', 'type' => 'GitHub', 'url' => 'https://github.com/huggingface/transformers', 'duration_minutes' => 120, 'difficulty_level' => 2, 'icon' => '🔧',
            ],
            [
                'title' => 'scikit-learn',
                'description' => 'Industry-standard library for classical ML.',
                'learning_reason' => 'Not every problem needs deep learning. Scikit-learn\'s classical algorithms — random forests, SVMs, clustering — are often faster, more interpretable, and perfectly sufficient for many business problems.',
                'category' => 'AI Frameworks', 'type' => 'GitHub', 'url' => 'https://github.com/scikit-learn/scikit-learn', 'duration_minutes' => 90, 'difficulty_level' => 2, 'icon' => '🔧',
            ],
            [
                'title' => 'JAX',
                'description' => 'High-performance numerical computing with composable transformations.',
                'learning_reason' => 'JAX offers automatic differentiation and XLA compilation for maximum performance. It\'s the framework of choice for cutting-edge research where speed and mathematical elegance matter.',
                'category' => 'AI Frameworks', 'type' => 'GitHub', 'url' => 'https://github.com/jax-ml/jax', 'duration_minutes' => 90, 'difficulty_level' => 3, 'icon' => '🔧',
            ],

            // Inference Tools
            [
                'title' => 'Ollama',
                'description' => 'Run LLMs locally with a single command.',
                'learning_reason' => 'Running models locally means no API costs, no data leaving your machine, and instant experimentation. Ollama makes this trivially easy — essential for prototyping and privacy-sensitive work.',
                'category' => 'Inference Tools', 'type' => 'GitHub', 'url' => 'https://github.com/ollama/ollama', 'duration_minutes' => 30, 'difficulty_level' => 1, 'icon' => '⚡',
            ],
            [
                'title' => 'vLLM',
                'description' => 'State-of-the-art LLM serving engine with PagedAttention.',
                'learning_reason' => 'When you need to serve LLMs at scale, vLLM\'s PagedAttention delivers up to 24x higher throughput than naive serving. Understanding efficient inference is critical for production AI systems.',
                'category' => 'Inference Tools', 'type' => 'GitHub', 'url' => 'https://github.com/vllm-project/vllm', 'duration_minutes' => 60, 'difficulty_level' => 3, 'icon' => '⚡',
            ],
            [
                'title' => 'llama.cpp',
                'description' => 'Pure C/C++ LLM inference with GGUF quantization.',
                'learning_reason' => 'llama.cpp proves you can run powerful LLMs on consumer hardware through quantization. Understanding inference optimization and quantization techniques is valuable for deploying AI anywhere.',
                'category' => 'Inference Tools', 'type' => 'GitHub', 'url' => 'https://github.com/ggerganov/llama.cpp', 'duration_minutes' => 60, 'difficulty_level' => 3, 'icon' => '⚡',
            ],
            [
                'title' => 'Free LLM API Resources',
                'description' => 'Comprehensive list of free-tier LLM APIs.',
                'learning_reason' => 'Knowing which LLM APIs offer free tiers lets you prototype and experiment without budget constraints. This resource helps you evaluate multiple providers before committing to one.',
                'category' => 'Inference Tools', 'type' => 'GitHub', 'url' => 'https://github.com/cheahjs/free-llm-api-resources', 'duration_minutes' => 20, 'difficulty_level' => 1, 'icon' => '⚡',
            ],

            // Fine-Tuning
            [
                'title' => 'Unsloth',
                'description' => '2x faster fine-tuning with 70% less memory.',
                'learning_reason' => 'Fine-tuning is how you adapt a general model to your specific domain. Unsloth makes this feasible on consumer GPUs, democratizing a capability that previously required expensive hardware.',
                'category' => 'Fine-Tuning', 'type' => 'GitHub', 'url' => 'https://github.com/unslothai/unsloth', 'duration_minutes' => 60, 'difficulty_level' => 3, 'icon' => '🎛️',
            ],
            [
                'title' => 'LLaMA-Factory',
                'description' => 'Unified fine-tuning framework supporting SFT, DPO, ORPO.',
                'learning_reason' => 'Different fine-tuning methods serve different goals — SFT for instruction following, DPO for preference alignment. LLaMA-Factory lets you experiment with all of them in one unified interface.',
                'category' => 'Fine-Tuning', 'type' => 'GitHub', 'url' => 'https://github.com/hiyouga/LLaMA-Factory', 'duration_minutes' => 90, 'difficulty_level' => 3, 'icon' => '🎛️',
            ],
            [
                'title' => 'PEFT',
                'description' => 'Parameter-efficient fine-tuning library — LoRA, QLoRA.',
                'learning_reason' => 'Full fine-tuning is expensive and often unnecessary. PEFT methods like LoRA train only a fraction of parameters while achieving comparable results — a must-know for practical fine-tuning.',
                'category' => 'Fine-Tuning', 'type' => 'GitHub', 'url' => 'https://github.com/huggingface/peft', 'duration_minutes' => 60, 'difficulty_level' => 3, 'icon' => '🎛️',
            ],
            [
                'title' => 'TRL',
                'description' => 'Full-stack RLHF, SFT, DPO, and reward modeling.',
                'learning_reason' => 'TRL is the go-to library for aligning language models with human preferences. Understanding RLHF and reward modeling is essential for building AI that\'s helpful, harmless, and honest.',
                'category' => 'Fine-Tuning', 'type' => 'GitHub', 'url' => 'https://github.com/huggingface/trl', 'duration_minutes' => 60, 'difficulty_level' => 3, 'icon' => '🎛️',
            ],

            // RAG & Vector
            [
                'title' => 'LlamaIndex',
                'description' => 'Full-featured RAG framework with advanced indexing.',
                'learning_reason' => 'RAG is the most practical way to give LLMs access to your private data without fine-tuning. LlamaIndex provides production-grade indexing, retrieval, and query pipelines out of the box.',
                'category' => 'RAG & Vector', 'type' => 'GitHub', 'url' => 'https://github.com/run-llama/llama_index', 'duration_minutes' => 90, 'difficulty_level' => 2, 'icon' => '🔍',
            ],
            [
                'title' => 'LangChain',
                'description' => 'Foundational library for building LLM-powered apps.',
                'learning_reason' => 'LangChain is the Swiss Army knife of LLM application development. Its chains, agents, and memory abstractions let you compose complex AI workflows from simple building blocks.',
                'category' => 'RAG & Vector', 'type' => 'GitHub', 'url' => 'https://github.com/langchain-ai/langchain', 'duration_minutes' => 120, 'difficulty_level' => 2, 'icon' => '🔍',
            ],
            [
                'title' => 'Chroma',
                'description' => 'Most popular open-source embedding database.',
                'learning_reason' => 'Vector databases are the backbone of semantic search and RAG. Chroma\'s simplicity makes it the best starting point for learning how embeddings enable similarity search at scale.',
                'category' => 'RAG & Vector', 'type' => 'GitHub', 'url' => 'https://github.com/chroma-core/chroma', 'duration_minutes' => 45, 'difficulty_level' => 2, 'icon' => '🔍',
            ],
            [
                'title' => 'Qdrant',
                'description' => 'High-performance vector search engine.',
                'learning_reason' => 'When your vector data grows beyond prototyping, you need a purpose-built engine. Qdrant handles filtering, multi-tenancy, and high-throughput search for production RAG systems.',
                'category' => 'RAG & Vector', 'type' => 'GitHub', 'url' => 'https://github.com/qdrant/qdrant', 'duration_minutes' => 45, 'difficulty_level' => 2, 'icon' => '🔍',
            ],
            [
                'title' => 'GraphRAG',
                'description' => 'Knowledge-graph-based retrieval for structured AI answers.',
                'learning_reason' => 'Traditional RAG struggles with multi-hop reasoning. GraphRAG uses knowledge graphs to connect information across documents, enabling AI to answer complex questions that require synthesizing multiple sources.',
                'category' => 'RAG & Vector', 'type' => 'GitHub', 'url' => 'https://github.com/microsoft/graphrag', 'duration_minutes' => 60, 'difficulty_level' => 3, 'icon' => '🔍',
            ],

            // Books
            [
                'title' => 'Hands-On ML with Scikit-Learn, Keras & TensorFlow',
                'description' => 'Go-to practical guide for ML engineers by Aurélien Géron.',
                'learning_reason' => 'This book takes you from zero to building real ML pipelines. Its hands-on projects with real datasets give you the practical experience that employers look for in ML engineers.',
                'category' => 'Books', 'type' => 'Book', 'url' => 'https://www.amazon.com/Hands-Machine-Learning-Scikit-Learn-TensorFlow/dp/1098125975', 'duration_minutes' => 2400, 'difficulty_level' => 2, 'icon' => '📕',
            ],
            [
                'title' => 'An Introduction to Statistical Learning',
                'description' => 'Widely used textbook for statistical learning methods.',
                'learning_reason' => 'ISLR bridges statistics and machine learning with accessible explanations and R/Python labs. It teaches you to think statistically about models — essential for making sound data-driven decisions.',
                'category' => 'Books', 'type' => 'Book', 'url' => 'https://www.statlearning.com/', 'duration_minutes' => 1800, 'difficulty_level' => 2, 'icon' => '📕',
            ],
            [
                'title' => 'Machine Learning Yearning',
                'description' => 'Practical guide focused on structuring ML projects by Andrew Ng.',
                'learning_reason' => 'Andrew Ng distills decades of ML project experience into actionable advice. This short guide teaches you how to diagnose what\'s wrong with your model and prioritize what to fix — invaluable in practice.',
                'category' => 'Books', 'type' => 'Book', 'url' => 'https://info.deeplearning.ai/machine-learning-yearning-book', 'duration_minutes' => 300, 'difficulty_level' => 2, 'icon' => '📕',
            ],

            // AI News
            [
                'title' => 'The Unwind AI - Tutorial Archive',
                'description' => 'Curated archive of hands-on AI tutorials.',
                'learning_reason' => 'Staying current with AI tutorials keeps your skills sharp in a rapidly evolving field. This curated archive filters the noise and surfaces the most practical, hands-on content.',
                'category' => 'AI News', 'type' => 'Blog', 'url' => 'https://www.theunwindai.com/archive?tags=AI+Tutorial', 'duration_minutes' => 30, 'difficulty_level' => 1, 'icon' => '📰',
            ],
        ];

        foreach ($resources as $resource) {
            Resource::updateOrCreate(
                ['title' => $resource['title']],
                $resource
            );
        }
    }
}
