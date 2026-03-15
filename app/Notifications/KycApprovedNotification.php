<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class KycApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('✅ Votre identité a été vérifiée — 5PSL')
            ->greeting("Bonjour {$notifiable->name},")
            ->line('Excellente nouvelle ! Votre dossier KYC a été **approuvé** par notre équipe.')
            ->line('Vous avez désormais accès à toutes les fonctionnalités de la plateforme :')
            ->line('- Effectuer des dépôts et retraits')
            ->line('- Voter sur les opportunités d\'investissement')
            ->line('- Parrainer de nouveaux membres')
            ->action('Accéder à mon espace', url('/investment/dashboard'))
            ->line('Merci pour votre confiance.')
            ->salutation('L\'équipe 5PSL');
    }

    public function toArray(object $notifiable): array
    {
        return ['type' => 'kyc_approved'];
    }
}
