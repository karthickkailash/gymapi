<?php

namespace App\Http\Controllers;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Api\CommonLibrary\CryptographyPlugin;
use Exception;
use Throwable;
use Illuminate\Support\Facades\DB;
abstract class Controller extends BaseController
{
    //

    use AuthorizesRequests, ValidatesRequests;


    /**
    * encryption check.
    * @param  string  $string
    * @return mixed
    */
    public function encryption($string)
    {
        if(!empty($string)) {
            $cryp=new CryptographyPlugin();
            $data = $cryp->encode($string);
            return $data;
        }
        return '';
    }

    /**
    * dec check.
    * @param  string  $string
    * @return mixed
    */
    public function dec($string)
    {
        if(!empty($string)) {

            $cryp=new CryptographyPlugin();
            $data = $cryp->decode($string);
            return $data;
        }
        return '';
    }

    /**
    * enc check.
    * @param  string  $string
    * @return mixed
    */
    public function enc($string)
    {
        if(!empty($string)) {
            $cryp=new CryptographyPlugin();
            $data = $cryp->encode($string);
            return $data;
        }
        return '';
    }

    
    /**
    * decryption check.
    * @param  string  $string
    * @return mixed
    */
    public function decryption($string)
    {

        if(!empty($string)) {
           $cryp=new CryptographyPlugin();
           $data = $cryp->decode($string);
           $data1 = json_decode($data);
           return $data1;
        }
        return '';
    }

}
