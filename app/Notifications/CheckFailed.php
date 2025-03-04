<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Check;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

final class CheckFailed extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly Check $check
    ) {}

    /**
     * @return array<int,string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->error()
            ->subject('Service Check Failed')
            ->line("We just checked your service -{$this->check->name}-, and it seems to be down.")
            ->line('Thank you for using our application!');
    }

    /**
     * @return array<string,string>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'check' => $this->check->id,
            'message' => "Your service {$this->check->name} seems to be down.",
        ];
    }
}
