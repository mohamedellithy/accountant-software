<?php

namespace App\Services;
use App\Models\User;
use App\Mail\VerifyCodeMail;
use Illuminate\Support\Facades\Mail;
class UserService
{

    public function sendUrl($phone,$url)
    {

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://graph.facebook.com/v15.0/101991479491271/messages',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "messaging_product": "whatsapp",
            "to": '. $phone.',
            "type": "template",
            "template": {
                "name": "hello_world",
                "language": {
                    "code": "en_US"
                }
            }
        }',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer EAARJUKPxk20BOxV3xUhlyxumHR3UlYJyDZBpZAafrrpcFq9tsKG2ZAE6O2U3uBOmcZAvlVhMT6Mpr6zeFKDFMtj3OAPsXeT9wzAGxCHXKaZCeHxWxUM5Ezs44K5HyDdkdngnMLBgRdxzQA8Yd44UpugzyT22QSp0O5p4FmeopeO0ZADAj6debAN500KzjO673AfccYycOHpewFcHZBPaMm63BSZBuD4a9qmUhZBUZD',

            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return TRUE;
    }


}
