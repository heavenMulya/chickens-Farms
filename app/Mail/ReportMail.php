<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class ReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $reportData;
    public string $reportType;
    public string $contentType;  // NEW

    /**
     * Create a new message instance.
     */
    public function __construct(array $reportData, string $reportType, string $contentType = 'business')
    {
        $this->reportData = $reportData;
        $this->reportType = $reportType;
        $this->contentType = $contentType;  // NEW
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: ucfirst($this->contentType) . ' ' . ucfirst($this->reportType) . ' Report',
        );
    }

    /**
     * Get the message content definition.
     */
  public function content(): Content
{
    return new Content(
        view: 'emails.report',
        with: [
            'reportData' => $this->reportData,
            'reportType' => $this->reportType,
            'appName' => config('app.name'), // This pulls from config/app.php
        ],
    );
}


    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
