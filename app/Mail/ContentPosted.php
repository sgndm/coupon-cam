<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContentPosted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $msg;
    public $linkurl;
    public $subject;
    public $linktext;
   
    public function __construct($msg,$url,$subject='Something updated on Coupon Go',$linktext = 'Check Now')
    {
        $this->msg = $msg;
        $this->linkurl = $url;
        $this->subject = $subject;
        $this->linktext  = $linktext;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.content')
        	->subject($this->subject)
        	->with([
                        'msg' => $this->msg,
                        'url' => $this->linkurl,
                        'linktext' => $this->linktext,
                    ]);
    }

    
}
