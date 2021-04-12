<?php


namespace App\Classes\Admin\Product\Product\Destroy;


class DeleteFileGallery
{
    protected $post;
    protected $request;

    public function __construct($post){
        $this->post                 = $post->destroy();
        $this->request              = $post->request();
    }

    public function request(){
        return  $this->request;
    }


    public function destroy()
    {
        if($this->post->FileGallery){
            $this->post->FileGallery()->delete();
        }

        return $this->post;
    }
}
