<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Mail\DailyReminder;
use App\Services\StreakService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendDailyReminders extends Command
{
    protected $signature = 'reminders:send {--dry-run : Run without sending emails}';

    protected $description = 'Send daily reminder emails to users';

    public function handle(StreakService $streakService): int
    {
        $this->info('Starting daily reminder emails...');

        $users = User::whereNotNull('email_verified_at')->get();
        $sent = 0;
        $skipped = 0;

        $bar = $this->output->createProgressBar($users->count());
        $bar->start();

        foreach ($users as $user) {
            $streak = $streakService->getOrCreateStreak($user);
            
            if ($streakService->hasVisitedToday($user)) {
                $skipped++;
                $bar->advance();
                continue;
            }

            if ($this->option('dry-run')) {
                $this->line("\nWould send reminder to: {$user->email}");
            } else {
                Mail::to($user)->send(new DailyReminder($user, $streak->current_streak));
            }

            $sent++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        if ($this->option('dry-run')) {
            $this->info("Dry run complete. Would have sent {$sent} emails, skipped {$skipped}.");
        } else {
            $this->info("Sent {$sent} reminder emails, skipped {$skipped} users (already visited today).");
        }

        return Command::SUCCESS;
    }
}
