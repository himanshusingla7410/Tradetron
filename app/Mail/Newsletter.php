<?php

namespace App\Mail;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class Newsletter extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public $subscriber)
    {
        if (! $subscriber){
            throw new Exception('Invalid subscriber for newsletter');
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Newsletter',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        try {
            Log::info('Mail sent to: '. $this->subscriber->email);

            return new Content(

                view: 'mail.newsletter',
            );
            
        } catch(\Throwable $e){

            Log::error("Newsletter View Rendering Error for {$this->subscriber->email}", ['error'=>$e->getMessage()]);

            throw new Exception('Failed to render newsletter view: '. $e->getMessage());

        }
        
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
