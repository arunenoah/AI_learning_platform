# LearnHub - Corporate Learning Platform

A curated learning platform built with Laravel and Tailwind CSS that aggregates AI/ML resources, learning paths, and quizzes into a single, trackable experience.

## What Problem Does This Solve?

Learning AI/ML is overwhelming. Resources are scattered across YouTube, GitHub, Coursera, blogs, and textbooks. Developers waste time **finding** what to learn instead of **actually learning**. LearnHub solves this by:

- **Curating 73+ vetted resources** across 16 categories (Claude Code, Prompt Engineering, AI Agents, ML Foundations, Deep Learning, RAG, Fine-Tuning, and more)
- **Explaining why each resource matters** — every resource includes a "Why learn this" section so learners understand the practical value before investing time
- **Providing structured learning paths** with step-by-step progression from beginner to advanced
- **Gamifying the experience** with points, badges, streaks, and leaderboards to maintain motivation
- **Tracking progress** so learners know exactly where they left off

## Key Features

### Public Resource Browsing
- Resources page is the **landing page** — no login required to browse
- All navigation menus visible to everyone (auth-gated pages redirect guests to login)
- Hover popup on resource cards shows quick preview with metadata and "Why learn this"
- Side panel with detailed view and embedded iframe for in-page reading

### Authentication & Security
- **Strong password policy**: Min 8 characters, mixed case, numbers, symbols
- **Breach detection**: Passwords checked against haveibeenpwned database via Laravel's `uncompromised()` rule
- **IP-based rate limiting**:
  - Login: 5 attempts per minute per IP
  - Signup: 15 attempts per hour per IP
  - Forgot password: 5 attempts per hour per IP
- Branded 429 error page when rate limits are hit
- Modern split-screen login/register UI matching platform branding

### Learning Resources
- 73+ resources across 16 categories
- Each resource includes: title, description, **learning reason** (why/how it helps), category, type, difficulty level, duration, and external URL
- Filter by category, difficulty level, or search by keyword
- Completion tracking with points (+25 per resource)

### Learning Paths
- Structured multi-step paths with ordered resources
- Progress tracking per path with step completion
- Paths span beginner to advanced topics

### Quizzes
- Multiple-choice quizzes with scoring
- Retake capability and result review
- Quiz attempts tracked per user

### Gamification
- Points system (resource visits, completions, quiz scores)
- Badge achievements (Explorer, Collector, Streak Warrior, etc.)
- Daily streak tracking
- Global leaderboard
- User profile with stats

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 11 (PHP 8.2+) |
| Frontend | Blade templates + Tailwind CSS (CDN) |
| Database | SQLite (default) / MySQL / PostgreSQL |
| Auth | Laravel Breeze (customized) |
| Fonts | Plus Jakarta Sans, Inter |

## Getting Started

### Prerequisites
- PHP 8.2+
- Composer
- SQLite (default) or MySQL/PostgreSQL

### Installation

```bash
# Clone the repository
git clone <repo-url> learning-platform
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

Visit `http://localhost:8000` — you'll land on the Resources page.

### Seeded Data

The `--seed` flag populates:
- **73 learning resources** across 16 categories with learning reasons
- **25 learning paths** with multi-step progressions
- **2+ quizzes** with 20+ questions each
- **16 badges** for achievements

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/                    # Authentication (Breeze, customized)
│   │   ├── DashboardController.php  # User dashboard
│   │   ├── ResourceController.php   # Resource browsing (public) & completion (auth)
│   │   ├── LearningPathController.php
│   │   ├── QuizController.php
│   │   └── ProgressController.php   # Profile, leaderboard, badges, stats
│   └── Requests/Auth/
│       └── LoginRequest.php         # IP-based rate limiting on login
├── Models/
│   ├── Resource.php                 # learning_reason field included
│   ├── User.php                     # Points, badges, progress relations
│   └── ...
├── Providers/
│   └── AppServiceProvider.php       # Password policy + rate limiters
└── Services/
    ├── ProgressService.php          # Resource visit/completion tracking
    ├── PointsService.php            # Points calculation
    └── StreakService.php            # Daily streak tracking

routes/
├── web.php                          # Public resource routes + auth-gated routes
└── auth.php                         # Throttled auth routes

resources/views/
├── layouts/
│   ├── app.blade.php                # Main layout (nav visible to all users)
│   └── guest.blade.php              # Auth layout (split-screen branded)
├── auth/                            # Login, register, forgot-password, etc.
├── resources/
│   ├── index.blade.php              # Resource grid with hover popup
│   └── show.blade.php               # Resource detail with "Why learn this"
├── components/                      # Blade components (branded)
└── errors/
    └── 429.blade.php                # Rate limit error page
```

## Security Measures

| Measure | Implementation |
|---------|---------------|
| Password strength | Min 8 chars, mixed case, number, symbol |
| Breach detection | haveibeenpwned API via `Password::uncompromised()` |
| Login throttling | 5 attempts/min per IP (route middleware + LoginRequest) |
| Signup throttling | 15 attempts/hour per IP |
| Forgot password throttling | 5 attempts/hour per IP |
| CSRF protection | All forms use `@csrf` |
| XSS prevention | Blade `{{ }}` auto-escaping, `e()` for data attributes |
| SQL injection | Eloquent ORM parameterized queries |

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
