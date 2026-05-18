<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PremiumSubscriptionNotification extends Notification
{
    use Queueable;

    protected $type;
    protected $expiryDate;

    /**
     * Create a new notification instance.
     *
     * @param string $type ('expiring_soon', 'expired', 'renewed')
     * @param string|null $expiryDate
     */
    public function __construct($type, $expiryDate = null)
    {
        $this->type = $type;
        $this->expiryDate = $expiryDate;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function channels($notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $mail = new MailMessage;

        switch ($this->type) {
            case 'expiring_soon':
                $mail->subject('Your Premium Subscription is Expiring Soon')
                     ->line('Your TAN Network Premium subscription will expire on ' . $this->expiryDate . '.')
                     ->line('Renew now to continue enjoying 10x mining speed and priority withdrawals.')
                     ->action('Renew Now', url('/upgrade'));
                break;

            case 'expired':
                $mail->subject('Your Premium Subscription Has Expired')
                     ->line('Your TAN Network Premium subscription has expired.')
                     ->line('Your mining rate has been reset to the standard rate.')
                     ->line('Upgrade again to restore your premium benefits.')
                     ->action('Upgrade to Premium', url('/upgrade'));
                break;

            case 'renewed':
                $mail->subject('Premium Subscription Renewed')
                     ->line('Congratulations! Your TAN Network Premium subscription has been renewed.')
                     ->line('Your new expiry date is ' . $this->expiryDate . '.')
                     ->line('Continue enjoying your premium benefits!')
                     ->action('Go to App', url('/'));
                break;
        }

        return $mail->footer('Thank you for being part of TAN Network!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable): array
    {
        $messages = [
            'expiring_soon' => "Your premium subscription expires on {$this->expiryDate}. Renew now!",
            'expired' => "Your premium subscription has expired. Upgrade now to restore benefits.",
            'renewed' => "Premium subscription renewed! Expires on {$this->expiryDate}.",
        ];

        return [
            'type' => $this->type,
            'message' => $messages[$this->type] ?? 'Premium status update',
            'expiry_date' => $this->expiryDate,
        ];
    }
}
