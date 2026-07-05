<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Booking;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $pdfContent;

    /**
     * Create a new message instance.
     */
    public function __construct(Booking $booking, $pdfContent)
    {
        $this->booking = $booking;
        $this->pdfContent = $pdfContent;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invoice Servis #WM-' . str_pad($this->booking->id, 5, '0', STR_PAD_LEFT) . ' - Wijaya Motor',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invoice-body',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->pdfContent, 'Invoice_WM_' . $this->booking->id . '.pdf')
                    ->withMime('application/pdf'),
        ];
    }
}
