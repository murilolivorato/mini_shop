<?php


namespace App\Classes\Admin\Product\Product;


use App\Classes\Admin\Product\Product\Save\SaveFileGallery;
use App\Classes\Admin\Product\Product\Save\SaveProduct;
use App\Classes\Admin\Product\Product\Save\DeleteFilesFromGallery;
use App\Classes\Admin\Product\Product\Save\DeleteImagesFromGallery;
use App\Classes\Admin\Product\Product\Save\MakeFolder;
use App\Classes\Admin\Product\Product\Save\SaveFiles;
use App\Classes\Admin\Product\Product\Save\SaveImageGallery;
use App\Classes\Admin\Product\Product\Save\SaveImages;
use App\Classes\Admin\Product\Product\Save\SaveProductOption;
use App\Classes\Admin\Product\Product\Save\SaveProductOptionItem;
use App\Classes\Admin\Product\Product\Save\DeleteProductOption;
use App\Classes\Admin\Product\Product\Save\DeleteProductOptionItem;
use App\Classes\Admin\Product\Product\Save\SaveVideoGallery;
use App\Classes\Admin\Product\Product\Save\SaveProductTag;
use App\Classes\Admin\Product\Product\Save\ProducPrice;

use App\Models\Product;
use App\Models\UserAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;




class ProcessSave
{
    protected $request;
    protected $result;
    protected $user;

    public static function process(Request $request , Product $product  ,  $user){

        return  (new static)->handle($request , $product , $user );
    }

    private function handle($request , $product , $user){
        return   $this->setRequest($request)
                      ->setUser($user)
                      ->save($product)
                      ->getResult();
    }

    // SET REQUEST
    private function setRequest($request){

        $this->request = $request;
        return $this;
    }

    // SET USER
    private function setUser($user){
        $this->user = $user != null ? UserAdmin::find($user->id) : null;
        return $this;
    }

    // SAVE BOOK
    private function save($product)
    {
        // START TRANSACTION
        DB::beginTransaction();

        // SAVE VIDEO GALLERY
        $product =   new DeleteImagesFromGallery(
                        // SAVE IMAGES IN GALLERY
                            new SaveImages(
                            // SAVE GALLERY INTO PROPERTY
                                new SaveImageGallery(
                                    //MAKE FOLDER
                                    new MakeFolder(
                                    // SALVA A FILIAL
                                        new SaveProduct($product ,
                                                        $this->request ,
                                                        $this->user )
                                    )
                                )
                            )


                );


        $this->result = $product->publish();

        // END TRANSACTION
        DB::commit();

        return $this;
    }

    public function getResult(){

        // ERRO
        if(! $this->result ){
            return response()->json(null , 400 );
        }

        // SUCESSO
        return response()->json(null , 200 );
    }
}
