<?php

namespace App\Mail;
use Illuminate\Support\Facades\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
//        return $this->view('view.mail',compact($this->data));
        $attachment = $this->data['attachment'];
        if($this->data['attachment'] == 'nofile.jpg'){
            return $this->from($this->data['from'])->subject($this->data['subject'])->view('mail')->with('data', $this->data);
        }
        else {
            return $this->from($this->data['from'])->subject($this->data['subject'])->attach(public_path($this->data['attachment']), array(
                'as' => $this->data['attachment'],
                'mime' => $this->data['attachment']
            ))->view('mail')->with('data', $this->data);
        }
    }
}
