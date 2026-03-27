<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Badge;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BadgeEarned extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public Badge $badge
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Congratulations! You Earned: {$this->badge->name}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.badge-earned',
        );
    }
}
