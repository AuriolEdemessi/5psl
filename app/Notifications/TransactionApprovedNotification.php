<?php

namespace App\Notifications;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransactionApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Transaction $transaction;

    /**
     * Create a new notification instance.
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
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
        $typeLabel = $this->transaction->type === 'depot' ? 'Dépôt' : 'Retrait';
        $color = $this->transaction->type === 'depot' ? '#059669' : '#0066ff';
        $montant = number_format((float)$this->transaction->montant, 2, ',', ' ');
        $montantNet = number_format((float)$this->transaction->montant_net, 2, ',', ' ');
        $frais = number_format((float)$this->transaction->frais_entree, 2, ',', ' ');
        
        $mail = (new MailMessage)
                    ->subject("✅ Transaction validée : {$typeLabel} de {$montant} USD")
                    ->greeting("Bonjour {$notifiable->name},")
                    ->line("Nous avons le plaisir de vous informer que votre demande de **{$typeLabel}** a été **validée** et traitée par l'administration.")
                    ->line("**Détails de la transaction :**")
                    ->line("- Type : {$typeLabel}")
                    ->line("- Montant brut : {$montant} USD");
                    
        if ($this->transaction->type === 'depot' && $this->transaction->frais_entree > 0) {
            $mail->line("- Frais d'entrée (2%) : {$frais} USD")
                 ->line("- Montant net investi : **{$montantNet} USD**");
        }
        
        if ($this->transaction->type === 'retrait' && $this->transaction->commission_hwm > 0) {
            $commission = number_format((float)$this->transaction->commission_hwm, 2, ',', ' ');
            $mail->line("- Commission de performance (HWM) : {$commission} USD");
        }

        return $mail->action('Voir mon portefeuille', url('/investment/dashboard'))
                    ->line('Merci pour votre confiance.')
                    ->salutation('L\'équipe 5PSL');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'transaction_id' => $this->transaction->id,
            'type' => $this->transaction->type,
            'amount' => $this->transaction->montant,
        ];
    }
}
