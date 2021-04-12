<?php


namespace App\Classes\Admin\Product\ProductCategory;

use App\Classes\Admin\Product\ProductCategory\Save\SaveImages;
use App\Classes\Admin\Product\ProductCategory\Save\SaveProductCategory;
use App\Models\ProductCategory;
use App\Models\UserAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcessSave
{
    protected $request;
    protected $result;
    protected $user;

    public static function process(Request $request , ProductCategory $product_category  ,  $user){

        return  (new static)->handle($request , $product_category , $user );
    }

    private function handle($request , $product_category , $user){
        return   $this->setRequest($request)
                      ->setUser($user)
                      ->save($product_category)
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
    private function save($product_category)
    {
        // START TRANSACTION
        DB::beginTransaction();

        // SALVA A FILIAL
        $product_category =   new SaveImages(
                                      // SAVE PRODUCT CATEGORY
                                      new SaveProductCategory($product_category ,
                                                              $this->request ,
                                                              $this->user
                                     )
                                );

        $this->result = $product_category->publish();

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
        return response()->json(null  , 200 );
    }
}
