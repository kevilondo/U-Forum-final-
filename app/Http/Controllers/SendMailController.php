<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\SendMail;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Jobs\MailQueue;

class SendMailController extends Controller implements ShouldQueue
{
    //
    public function send($name, $user_email, $message, $url)
    {
        $data = [
            'name' => $name,

            'message' => $message,

            'url' => $url
        ];

        Mail::to($user_email)->send(new SendMail($data));
    }
}
