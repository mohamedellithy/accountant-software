<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\View;
use App\Services\UserService;

class WhatsAppController extends Controller
{
    protected $userService;

    public function __construct(UserService $userSE)
    {
        $this->userService = $userSE;
    }

    public function teckScreen(Request $request){


        $urlPage =$request->url;
        $phone =$request->phone;
        $imag_name = date('mdYHis') . uniqid();
        // Generate PDF using Browsershot
        Browsershot::url($urlPage)
            ->format('A4')
            ->margins(10, 10, 10, 10)
            ->save('public/img/'. $imag_name .'.png');

        $urlimg='http://127.0.0.1:8000/img/'. $imag_name .'.png';

        if($this->userService->sendUrl($phone,$urlimg)){
            return redirect()->back('')->with('success_message', 'تم ارسال الفاتوره بنجاح');
        }

        return redirect()->back()->withErrors('خطاء في البيانات');


    }

}
