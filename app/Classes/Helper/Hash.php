<?php


namespace App\Classes\Helper;


use Hashids\Hashids;

class Hash
{
    public static function folder($salt){
        $hashids = new Hashids($salt, 6, 'qwertyiopasdfghjkllzxcvbnm123456789');
       return $hashids->encode(1);
    }

    public static function token($salt){
        $hashids = new Hashids($salt, 8, 'qwertyiopasdfghjkllzxcvbnm123456789');
        return $hashids->encode(1);
    }


}
