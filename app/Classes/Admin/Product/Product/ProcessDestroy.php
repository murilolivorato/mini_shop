<?php


namespace App\Classes\Admin\Product\Product;

use App\Classes\Admin\Product\Product\Destroy\DeleteFileGallery;
use App\Classes\Admin\Product\Product\Destroy\DeleteFilesFromGallery;
use App\Classes\Admin\Product\Product\Destroy\DeleteFolder;
use App\Classes\Admin\Product\Product\Destroy\DeleteImageGallery;
use App\Classes\Admin\Product\Product\Destroy\DeleteImagesFromGallery;
use App\Classes\Admin\Product\Product\Destroy\DeleteProduct;
use App\Classes\Admin\Product\Product\Destroy\DeleteVideoGallery;
use App\Classes\Admin\Product\Product\Destroy\DeleteProductOptionItems;
use App\Classes\Admin\Product\Product\Destroy\DeleteProductTags;
use App\Classes\Admin\Product\Product\Destroy\DeleteProductPrice;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProcessDestroy
{
    protected $request;
    protected $list_index = [];


    public static function process($request){
        return  (new static)->handle($request);
    }

    private function handle($request){
        return   $this->setRequest($request)
                      ->destroy()
                      ->result();
    }

    // SET REQUEST
    private function setRequest($request){

        $this->request = $request;
        return $this;
    }


    private function destroy(){

     // START TRANSACTION
     DB::beginTransaction();
        foreach($this->request['delete'] as $deleteItem) {

            $product = Product::find($deleteItem['id']);


            $product =   new DeleteProduct(
                                // DELETE FOLDER
                                new DeleteFolder(
                                            // DELETE PRODUCT OPTION
                                            new DeleteProductOptionItems(
                                                // DELETE IMAGE GALKLERY
                                                    new DeleteImageGallery(
                                                    // DELETE IMAGES FROM GALLERY
                                                        new DeleteImagesFromGallery( $product )
                                                    )
                                                 )
                                        )
                    );

            if($product->destroy() == true ){
                // push index into index , to make VUE effect to delete
                array_push($this->list_index , $deleteItem['index']);
            }
        }

        // END TRANSACTION
        DB::commit();


        return $this;
    }

    private function result(){

        if(empty($this->list_index)){
            return response()->json(['message' => 'Erro, Comunique o Suporte' ] , 400);
        }

        // success
        return response()->json(['index'   => $this->list_index  ] , 200 );
    }
}
