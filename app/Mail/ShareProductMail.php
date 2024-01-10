<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ShareProductMail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailData;
    private $attachmentPaths;

    /**
     * Create a new message instance.
     *
     * @param array $emailData
     * @param array $attachmentPaths
     */
    public function __construct($emailData, $attachmentPaths = [])
    {
        $this->emailData = $emailData;
        $this->attachmentPaths = $attachmentPaths;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Share Product Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return (new Content())->view('emails.share-product')->with('emailData', $this->emailData);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        foreach ($this->attachmentPaths as $attachmentPath) {
            $this->attach($attachmentPath);
        }

        return $this;
    }
}
