<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class KycRejectedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected ?string $reason;

    public function __construct(?string $reason = null)
    {
        $this->reason = $reason;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('❌ Vérification KYC refusée — 5PSL')
            ->greeting("Bonjour {$notifiable->name},")
            ->line('Nous avons le regret de vous informer que votre dossier KYC a été **refusé**.');

        if ($this->reason) {
            $mail->line("**Motif :** {$this->reason}");
        }

        return $mail->line('Vous pouvez soumettre à nouveau vos documents en vous rendant sur votre espace KYC.')
            ->action('Soumettre à nouveau', url('/kyc'))
            ->line('Si vous avez des questions, n\'hésitez pas à contacter le support.')
            ->salutation('L\'équipe 5PSL');
    }

    public function toArray(object $notifiable): array
    {
        return ['type' => 'kyc_rejected', 'reason' => $this->reason];
    }
}
