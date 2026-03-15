<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MonthlyReportMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $userName;
    public string $solde;
    public string $portfolioValue;
    public string $roi;
    public string $nav;
    public string $reportDate;
    public array $recentTransactions;

    /**
     * Create a new message instance.
     */
    public function __construct(
        string $userName,
        string $solde,
        string $portfolioValue,
        string $roi,
        string $nav,
        string $reportDate,
        array $recentTransactions = []
    ) {
        $this->userName = $userName;
        $this->solde = $solde;
        $this->portfolioValue = $portfolioValue;
        $this->roi = $roi;
        $this->nav = $nav;
        $this->reportDate = $reportDate;
        $this->recentTransactions = $recentTransactions;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📊 Rapport Mensuel 5PSL - ' . $this->reportDate,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.monthly-report',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
