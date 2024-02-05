<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use App\Models\PayMethods;
use App\Models\Bill;

class ReportMail extends Mailable
{
    use Queueable, SerializesModels;
    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $this->details = array();
        $payMethods = PayMethods::get();
        $this->details['title'] = 'تفاصيل تقرير اليوم   الخاص بكم ';
        $this->details['body'] = 'تفاصيل التقرير ';
        $this->details['total'] = Bill::whereDate('bill_date', Carbon::today())->sum('bill_total');
        $this->details['Vat'] = Bill::whereDate('bill_date', Carbon::today())->sum('bill_vat_val');
        $this->details['count'] = Bill::whereDate('bill_date', Carbon::today())->count();
        foreach ($payMethods as $pay) {
            $this->details[$pay->pay_method_name_en] = Bill::where('bill_paid_Type', $pay->id)->whereDate('bill_date', Carbon::today())->sum('bill_total');
            $this->details[$pay->pay_method_name_en . 'Vat'] = Bill::where('bill_paid_Type', $pay->id)->whereDate('bill_date', Carbon::today())->sum('bill_vat_val');
            $this->details[$pay->pay_method_name_en . 'Count'] = Bill::where('bill_paid_Type', $pay->id)->whereDate('bill_date', Carbon::today())->count();
        }


        return $this->subject('التقرير اليومي لبرنامج الكاشير الخاص بكم ')->view('Emails.mail');
    }
}
