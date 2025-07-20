<?php
namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewConnectionRequest extends Notification
{
    use Queueable;

    public User $requester;
    /**
     * Create a new notification instance.
     */
    public function __construct(User $requester)
    {
        $this->requester = $requester;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'requester_id'   => $this->requester->id,
            'requester_name' => $this->requester->name,
            'message'        => $this->requester->name . ' has sent you a connection request.',
            'url'            => route('professionals.show', $this->requester), // Link to the requester's profile
        ];
    }
}
