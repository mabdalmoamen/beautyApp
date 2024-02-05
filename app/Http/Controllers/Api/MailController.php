<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Mail\ReportMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    /**
     * Ship the given order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request)
    {
        $details = [
            'title' => 'Mail from veronica',
            'body' => 'This is for testing'
        ];
        Mail::to('codies.solutions@gmail.com')->send(new ReportMail($details));
    }
}
