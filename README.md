# LearnHub - AI/ML Learning Platform

A curated learning platform built with Laravel and Tailwind CSS that aggregates AI/ML resources, learning paths, quizzes, and Claude Code materials into a single, trackable experience.

## What Problem Does This Solve?

Learning AI/ML is overwhelming. Resources are scattered across YouTube, GitHub, Coursera, blogs, and textbooks. Developers waste time **finding** what to learn instead of **actually learning**. LearnHub solves this by:

- **Curating 1600+ vetted resources** across categories including Claude Code, Prompt Engineering, AI Agents, ML Foundations, Deep Learning, RAG, Fine-Tuning, and more
- **Explaining why each resource matters** — every resource includes a "Why learn this" section
- **Providing structured learning paths** with step-by-step progression from beginner to advanced
- **Gamifying the experience** with points, badges, and streaks to maintain motivation
- **Tracking progress** so learners know exactly where they left off

## Key Features

### Resource Browsing (Public)
- Blogs page is the **landing page** — no login required to browse
- Filter by category (horizontal pill tabs), difficulty level, or keyword search
- Hover popup on cards shows quick preview with metadata and "Why learn this"
- Slide-in detail pane with embedded iframe for in-page reading

### Claude Code Materials
- Dedicated section for Claude Code resources: Skills, Agents, Commands, MCPs, Settings, Hooks, Templates, Plugins
- Sourced from `data.json` and importable via `php artisan import:claude-materials`

### Authentication & Security
- **Strong password policy**: Min 8 characters, mixed case, numbers, symbols
- **Breach detection**: Passwords checked against haveibeenpwned via `Password::uncompromised()`
- **IP-based rate limiting**: Login (5/min), Signup (15/hr), Forgot password (5/hr)
- Editorial split-screen login/register UI with dark left panel and orange branding

### Learning Paths & Quizzes
- Structured multi-step paths with ordered resources and progress tracking
- Multiple-choice quizzes with scoring, retake capability, and result review

### Gamification
- Points system (resource visits, completions, quiz scores)
- Badge achievements, daily streak tracking, user profile with stats

## Design System

| Element | Value |
|---------|-------|
| Primary colour | Orange `#ea580c` |
| Header / left panels | Dark `#18181b` |
| Canvas background | Off-white `#fafaf8` |
| Heading font | Playfair Display (serif) |
| Body font | DM Sans |
| Mono / numbers | DM Mono |

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 11 (PHP 8.2+) |
| Frontend | Blade templates + Tailwind CSS (CDN) |
| Database | SQLite (default) / MySQL / PostgreSQL |
| Auth | Laravel Breeze (customized) |
| Fonts | Playfair Display, DM Sans, DM Mono |

## Getting Started

### Prerequisites
- PHP 8.2+
- Composer
- SQLite (default) or MySQL/PostgreSQL

### Installation

```bash
# Clone the repository
git clone https://github.com/arunenoah/AI_learning_platform.git learning-platform
cd learning-platform

# Install dependencies
composer install

# Configure environment
cp .env.example .env
php artisan key:generate

# Run migrations and seed data
php artisan migrate:fresh --seed

# Start the development server
php artisan serve
```

Visit `http://localhost:8000` — you'll land on the Blogs (resources) page.

### Import Claude Code Materials

```bash
# Preview what would be imported (dry run)
php artisan import:claude-materials --dry-run

# Import into the resources table
php artisan import:claude-materials
```

### Seeded Data

The `--seed` flag populates:
- **1600+ learning resources** across 16+ categories with learning reasons
- **25 learning paths** with multi-step progressions
- **17 quizzes** with questions and scoring
- **16 badges** for achievements

## Project Structure

```
app/
├── Console/Commands/
│   └── ImportClaudeCodeMaterials.php   # Artisan command to import data.json
├── Http/Controllers/
│   ├── Auth/                           # Authentication (Breeze, customized)
│   ├── ResourceController.php          # Blogs/resources (public + auth)
│   ├── ClaudeCodeMaterialsController.php
│   ├── LearningPathController.php
│   ├── QuizController.php
│   ├── QuestController.php
│   └── ProgressController.php          # Profile, badges, stats
├── Models/
│   ├── Resource.php
│   ├── LearningQuest.php
│   ├── DailyChallenge.php
│   └── User.php
└── Services/
    ├── ProgressService.php
    ├── PointsService.php
    └── StreakService.php

routes/
├── web.php                             # Public + auth-gated routes
├── api.php                             # API endpoints
└── auth.php                            # Throttled auth routes

resources/views/
├── layouts/
│   ├── app.blade.php                   # Main layout — top nav only, orange theme
│   └── guest.blade.php                 # Auth layout — dark left panel, editorial
├── auth/                               # Login, register, forgot-password
├── resources/
│   └── index.blade.php                 # Blogs page — resource grid
├── claude-code-materials.blade.php     # CC Materials SPA page
└── components/                         # Branded Blade components

public/
├── data.json                           # Claude Code materials source data
└── claude-code-materials/              # Static assets for CC Materials page
```

## Security Measures

| Measure | Implementation |
|---------|---------------|
| Password strength | Min 8 chars, mixed case, number, symbol |
| Breach detection | haveibeenpwned API via `Password::uncompromised()` |
| Login throttling | 5 attempts/min per IP |
| Signup throttling | 15 attempts/hour per IP |
| Forgot password throttling | 5 attempts/hour per IP |
| CSRF protection | All forms use `@csrf` |
| XSS prevention | Blade `{{ }}` auto-escaping, `e()` for data attributes |
| SQL injection | Eloquent ORM parameterized queries |

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
