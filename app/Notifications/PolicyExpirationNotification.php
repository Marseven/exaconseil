<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Policy;

class PolicyExpirationNotification extends Notification
{
    use Queueable;

    protected $policy;

    public function __construct(Policy $policy)
    {
        $this->policy = $policy;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Notification de police expirée')
            ->line('La police suivante est sur le point d\'expirer :')
            ->line('Nom de la politique : ' . $this->policy->name)
            ->line('Date d\'expiration : ' . $this->policy->date_expired)
            ->action('Voir la politique', url('/policies/' . $this->policy->id))
            ->line('Merci de votre attention.');
    }

    public function toArray($notifiable)
    {
        return [
            // Ajoutez ici des données supplémentaires à transmettre dans d'autres canaux
        ];
    }
}
