<?php

namespace App\Http\Controllers\Api\Plus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LibsodiumTestController extends Controller
{
    //
    public function enclib(Request $request)
    {

       
        $dd=$this->encryption($request->data);
        echo $dd;
    }

    public function declib(Request $request)
    {

       
        $dd=$this->decryption($request->data);
        dd($dd->email);
    }
}
