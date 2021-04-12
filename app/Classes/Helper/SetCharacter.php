<?php
namespace app\Classes\Helper;



class SetCharacter {

    public static function  makeLowercase($char){
        $change_accent = htmlentities($char, 0, 'UTF-8');
        return strtolower($change_accent);
    }

    public static function makeUpercase($char)
    {
        $encoding = mb_internal_encoding();
        return mb_strtoupper($char, $encoding);
    }

    public static function makeUrlTitle($str){
        $str = strtolower(utf8_decode($str)); $i=1;
        $str = strtr($str, utf8_decode('àáâãäåæçèéêëìíîïñòóôõöøùúûýýÿ'), 'aaaaaaaceeeeiiiinoooooouuuyyy');
        $str = preg_replace("/([^a-z0-9])/",'-',utf8_encode($str));
        while($i>0) $str = str_replace('--','-',$str,$i);
        if (substr($str, -1) == '-') $str = substr($str, 0, -1);
        return $str;
    }

    public static function minMaxURL($min , $max ){
        $separator        = '-a-';
        $max_value_prefix = 'ate-';
        $min_value_prefix =  'a-partir-de-';

        if($min != null && $max != null){
            return $min . $separator . $max;
        }

        if($min != null){
            return $min_value_prefix . $min;
        }

        if($max != null){
            return $max_value_prefix . $max;
        }
    }

}
