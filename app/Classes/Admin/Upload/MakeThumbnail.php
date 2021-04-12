<?php
namespace App\Classes\Upload;
use Image;


class MakeThumbnail {

    protected  $src;
    protected  $destination;

    public function __construct( $src,  $destination ){

        $this->src            = $src;
        $this->destination    = $destination;


    }
    /* CREATE IMAGE  */
    public function create_image_resize($image_action){

        switch ($image_action) {

            case 'image_post_1':
               $this->image_post_1();
                break;

            case 'image_post_2':
                /* make thumb */
                $this->image_post_2();
                break;

            case 'image_profile_1':
                /* make thumb */
                $this->image_profile_1();
                break;

            case 'image_message_1':
                /* make thumb */
                $this->image_message_1();
                break;

            default:
                /* make thumb */
                $this->image_gallery_1();
                break;

        }

    }

    /* horizontal image */
    public function image_gallery_1() {

        Image::make($this->src)
            ->resize(990, 680)
            ->save($this->destination);


    }
    /* vertical image */
    public function image_gallery_2() {

        Image::make($this->src)
            ->resize(660, 900)
            ->save($this->destination);


    }

    public function image_gallery_1_thumb() {

        Image::make($this->src)
            ->resize(300, 216)
            ->save($this->destination);


    }

    public function image_depoimento() {

        Image::make($this->src)
            ->resize(300, 216)
            ->save($this->destination);


    }

    // IMAGE PROFILE
    public function image_post_1() {

        Image::make($this->src)
            ->resize(376, 213)
            ->save($this->destination);


    }

    public function image_post_2() {

        Image::make($this->src)
            ->resize(640, null , function ($constraint) {

                $constraint->upsize();
            })
            ->save($this->destination);


    }

    public function image_message_1() {

        Image::make($this->src)
            ->resize(1200, null , function ($constraint) {

                $constraint->upsize();
            })
            ->save($this->destination);


    }


    // IMAGE PROFILLE
    public function image_profile_1() {

        Image::make($this->src)
            ->fit(400, 350 , function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save($this->destination);


    }




    public function image_lightbox() {

        Image::make($this->src)
            ->resize(600, null )
            ->save($this->destination);



    }



}