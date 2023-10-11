<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\View;


class WhatsAppController extends Controller
{
    public function teckScreen(){
         $url = 'http://127.0.0.1:8000/purchasing-invoices/1';

        // Generate PDF using Browsershot
        Browsershot::url($url)
            ->format('A4')
            ->margins(10, 10, 10, 10)
            ->save('public/pdf/example.pdf');

        return 'PDF generated successfully.';


    }

}
