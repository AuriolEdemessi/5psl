<?php

namespace App\Notifications;

use App\Models\InvestmentOpportunity;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOpportunityNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected InvestmentOpportunity $opportunity;

    /**
     * Create a new notification instance.
     */
    public function __construct(InvestmentOpportunity $opportunity)
    {
        $this->opportunity = $opportunity;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('🚀 Nouvelle Opportunité d\'Investissement - ' . $this->opportunity->titre)
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Une nouvelle opportunité d\'investissement vient d\'être publiée sur la plateforme 5PSL.')
            ->line('**' . $this->opportunity->titre . '**')
            ->line('Type : ' . ucfirst($this->opportunity->type))
            ->line(($this->opportunity->montant_estime
                ? 'Montant estimé : ' . number_format((float)$this->opportunity->montant_estime, 2, ',', ' ') . ' FCFA'
                : ''))
            ->line('Description : ' . \Illuminate\Support\Str::limit($this->opportunity->description, 200))
            ->action('Voir l\'opportunité et voter', url('/opportunities/' . $this->opportunity->id))
            ->line('Votre vote compte ! Connectez-vous pour approuver ou rejeter cette opportunité.')
            ->salutation('L\'équipe 5PSL');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'opportunity_id' => $this->opportunity->id,
            'titre' => $this->opportunity->titre,
            'type' => $this->opportunity->type,
        ];
    }
}
