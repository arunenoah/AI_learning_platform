<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DailyReminder extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public int $streakDays
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Don't Break Your {$this->streakDays}-Day Streak!",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.daily-reminder',
        );
    }
}
