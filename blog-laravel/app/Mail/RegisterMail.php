<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    private $vcode;
    private $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($vcode)
    {
        $this->vcode = $vcode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');
        $this->url = env('APP_URL')."/api/register/active/?v=".$this->vcode;
        return $this->from(env('MAIL_FROM_ADDRESS','www@wwzc.cc'))
                    ->view('email.register')
                    ->subject('网站注册验证')
                    ->with(['url'=>$this->url]);
                    // ->attach($this->path, ['as' => "=?UTF-8?B?". base64_encode($this->bookname.'.'.$this->extension) . "?="])
    }
}
