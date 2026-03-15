<?php

namespace App\Notifications;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransactionRejectedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Transaction $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $typeLabel = $this->transaction->type === 'depot' ? 'Dépôt' : 'Retrait';
        $montant = number_format((float)$this->transaction->montant, 2, ',', ' ');

        return (new MailMessage)
            ->subject("❌ Transaction refusée : {$typeLabel} de {$montant} USD")
            ->greeting("Bonjour {$notifiable->name},")
            ->line("Votre demande de **{$typeLabel}** de **{$montant} USD** a été **refusée** par l'administration.")
            ->line('Si vous pensez qu\'il s\'agit d\'une erreur, veuillez contacter le support.')
            ->action('Contacter le support', url('/support'))
            ->line('Merci de votre compréhension.')
            ->salutation('L\'équipe 5PSL');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'transaction_id' => $this->transaction->id,
            'type' => $this->transaction->type,
        ];
    }
}
