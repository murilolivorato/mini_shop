<?php


namespace App\Classes\Auth;


class VerifyTokenValid
{
    public static function process($date , $verify_date){
        $dateFromDatabase = strtotime($date);
        $dateTwelveHoursAgo = strtotime("-".$verify_date);

        return $dateFromDatabase >= $dateTwelveHoursAgo ? true : false ;
    }
}
