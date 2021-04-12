<?php


namespace App\Classes\Admin\Product\Product\Save;


class SaveVideoGallery
{
    protected $product;
    protected $request;
    protected $user;
    protected $action;

    public function __construct($product){
        $this->product        = $product->publish();
        $this->request        = $product->request();
        $this->user           = $product->user();
        $this->action         = $product->action();
    }

    public function request(){
        return  $this->request;
    }

    public function user(){
        return  $this->user;
    }

    public function action(){
        return  $this->action;
    }

    public function publish()
    {

        // DELETE ALL VIDEOS
        if($this->action == 'update') {
            $this->deleteAllVideos();
        }

        // ADD VIDEOS
        if (!empty($this->request['video_gallery'])):

            foreach($this->request['video_gallery'] as $key => $video) {


                $this->createVideoDisplay($video);


            }



        endif;

        return true;
    }



    /**********************************************************************************
    DELETE IMAGE
     ***********************************************************************************/
    public function deleteAllVideos(){
        // SE EXISTE VIDEOS
        if($this->product->Videos()->exists()){
            $this->product->Videos()->delete();
        }


    }

    /**********************************************************************************
    CREATE VIDEOS
     ***********************************************************************************/
    public function createVideoDisplay($video){


        // action : CREATE ? UPDATE
        $this->product->Videos()->create([ 'video_website_id'     => $video['video_website_id'] ,
                                           'title'                => $video['title'] ,
                                           'description'          => $video['description'] ,
                                           'reference'            => $video['reference'] ,
                                           'user_id'              => $this->user->id ,
                                           'user_ip'              => ip2long($_SERVER['REMOTE_ADDR']) ]);


    }

    /**********************************************************************************
    UPDATE VIDEOS
     ***********************************************************************************/
    public function updateVideoDisplay($video , $index){

        // action : CREATE ? UPDATE
        $this->product->Videos[$index]->update(['video_website_id'     => $video['video_website_id'] ,
                                                'title'                => $video['title'] ,
                                                'description'          => $video['description'] ,
                                                'reference'            => $video['reference'] ,
                                                'user_id'              => $this->user->id ,
                                                'user_ip'              => ip2long($_SERVER['REMOTE_ADDR']) ]);


    }




}
