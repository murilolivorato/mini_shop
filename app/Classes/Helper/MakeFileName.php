<?php
namespace app\Classes\Helper;


class MakeFileName {


    public static function create($fileName){
        $image = sha1(
            time(). $fileName->getClientOriginalName()
        );
        $extension = $fileName->getClientOriginalExtension();
        return $image . "." .$extension;
    }


    public static function encriptName($file){
        $file    = explode(".", $file  );

        return sha1(time(). $file[0]) . "." .$file[1];
    }


    public static function makeThumb($file) {

        $file    = explode(".", $file  );

        return $file[0]."_thumb.".$file[1];
    }



}