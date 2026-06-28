<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

// We DO NOT import Envelope, Content, or Attachment in Laravel 8
// use Illuminate\Mail\Mailables\Envelope; // REMOVE THIS
// use Illuminate\Mail\Mailables\Attachment; // REMOVE THIS
// use Illuminate\Mail\Mailables\Content; // REMOVE THIS


class ScrutinyCommitteeNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The public properties will be automatically available in the email view.
     */
    public $customSubject;
    public $customMessage;

    /**
     * Protected properties are for internal use within the class.
     */
    protected $excelData;
    protected $fileName;

    /**
     * Create a new message instance.
     * The constructor remains the same.
     *
     * @param string $subject
     * @param string $message
     * @param string $excelData
     * @param string $fileName
     */
    public function __construct(string $subject, string $message, string $excelData, string $fileName)
    {
        $this->customSubject = $subject;
        $this->customMessage = $message;
        $this->excelData = $excelData;
        $this->fileName = $fileName;
    }

    /**
     * Build the message.
     * This is the primary method used in Laravel 8 to construct the email.
     *
     * @return $this
     */
    public function build()
    {
        // We chain all the methods together inside build()
        return $this->subject($this->customSubject)
                    ->view('office.benefits.emails.scrutiny-notifications')
                    ->attachData($this->excelData, $this->fileName, [
                        'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    ]);
    }

    // The envelope(), content(), and attachments() methods are completely removed.
}
