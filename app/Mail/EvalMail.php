<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EvalMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $student;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $student)
    {
        $this->subject = $subject;
        $this->student = $student;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->markdown('mails.eval.form', ['student' => $this->student]);
    }
}
