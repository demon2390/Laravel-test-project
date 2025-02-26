<?php

namespace App\Notifications\Users;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendEmailVerificationNotification extends VerifyEmail implements ShouldQueue
{
    use Queueable;

    private string $token;

    public function __construct(
        private readonly User $user
    ) {
        $this->token = $user->newToken ?? null;
    }

    public function toMail($notifiable): MailMessage
    {
        /** @var User $notifiable */
        $verificationUrl = $this->verificationUrl($this->user);

        return (new MailMessage)
            ->subject('Verify Email Address')
            ->line("Your Bearer API token is {$this->token}")
            ->line('Please click the button below to verify your email address.')
            ->action('Verify Email Address', $verificationUrl)
            ->line('If you did not create an account, no further action is required.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            "token"            => "Your Bearer API token is {$notifiable->token}",
            "verification_url" => $notifiable->verificationUrl,
        ];
    }
}
