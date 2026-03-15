<?php

namespace App\Notifications;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransactionPendingNotification extends Notification implements ShouldQueue
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
        $typeLabel = $this->transaction->type === 'depot' ? 'Nouveau dépôt' : 'Nouvelle demande de retrait';
        $montant = number_format((float)$this->transaction->montant, 2, ',', ' ');
        
        return (new MailMessage)
                    ->subject("🚨 Action requise : {$typeLabel} en attente")
                    ->greeting("Bonjour Admin,")
                    ->line("L'utilisateur **{$this->transaction->user->name}** ({$this->transaction->user->email}) a soumis une transaction qui nécessite votre validation.")
                    ->line("**Détails :**")
                    ->line("- Type : {$this->transaction->type}")
                    ->line("- Montant brut : {$montant} USD")
                    ->line("- Description : " . ($this->transaction->description ?: 'Aucune'))
                    ->action('Examiner la transaction', url('/investment/admin'))
                    ->line('Merci de traiter cette demande dans les plus brefs délais.');
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
