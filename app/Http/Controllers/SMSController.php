<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Twilio\Rest\Client;

class SMSController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function sendWhatsApp()
    {
        // 01006878746
        $receiverNumber = "whatsapp:+966533928103";
        $message = "تجربة رسائل الواتس اب بالعربي";

        try {

            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_TOKEN");
            $twilio_number = getenv("TWILIO_FROM");
            $twilio = new Client($account_sid, $auth_token);
            $message = $twilio->messages
                ->create(
                    $receiverNumber, // to
                    [
                        "from" => $twilio_number,
                        "body" => $message
                    ]
                );
            print($message->sid);
        } catch (Exception $e) {
            dd("Error: " . $e->getMessage());
        }
    }
    public function sendSms($receiverNumber, $message)
    {
        // 01006878746
        // $receiverNumber = "whatsapp:+966533928103";
        // $message = "Test Whats App Api From Codies Pos Apps, Mostafa";

        try {

            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_TOKEN");
            $twilio_number = getenv("TWILIO_FROM");
            $twilio = new Client($account_sid, $auth_token);

            $Sms = $twilio->messages
                ->create(
                    "+201009199086", // to
                    array(
                        "from" => "+16073884683",
                        "body" => "Test Sms By twilio From Codies Mostafa"
                    )
                );
            print($Sms->sid);

            // dd('SMS Sent Successfully.');
        } catch (Exception $e) {
            dd("Error: " . $e->getMessage());
        }
    }
}
