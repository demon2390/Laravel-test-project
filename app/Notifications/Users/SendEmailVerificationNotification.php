<?php

declare(strict_types=1);

namespace App\Notifications\Users;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\HtmlString;

final class SendEmailVerificationNotification extends VerifyEmail implements ShouldQueue
{
    use Queueable;

    private string $token;

    public function __construct(
        private readonly User $user
    ) {
        $this->token = $user->newToken ?? null; // @phpstan-ignore-line
    }

    public function toMail($notifiable): MailMessage
    {
        /** @var User $notifiable */
        $verificationUrl = $this->verificationUrl($this->user);

        return (new MailMessage())
            ->subject('Verify Email Address')
            ->line(new HtmlString("Your Bearer API token is <br><b>Bearer {$this->token}<b>"))
            ->line('Please click the button below to verify your email address.')
            ->action('Verify Email Address', $verificationUrl)
            ->line('If you did not create an account, no further action is required.');
    }
}
