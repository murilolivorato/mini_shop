<?php


namespace App\Classes\Admin\Product\ProductCategory;

use App\Classes\Admin\Product\ProductCategory\Destroy\DestroyProductCategory;
use App\Classes\Admin\Product\ProductCategory\Destroy\DeleteImage;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;

class ProcessDestroy
{
    protected $request;
    protected $list_index = [];
    protected $has_product = false;
    protected $has_sub_category_products = false;


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

    // DESTROY BOOK
    private function destroy(){
        // START TRANSACTION
        DB::beginTransaction();
        foreach($this->request['delete'] as $deleteItem) {

            $productCategory = ProductCategory::find($deleteItem['id']);

            if(!$productCategory ){
                continue;
            }

            // VERIFICA SE POSSUI PRODUTOS CADASTRADOS
            if(count($productCategory->Products)){
                $this->has_product = true;
                continue;
            }

            if(count($productCategory->SubCategory)){
                $this->has_sub_category_products = true;
                continue;
            }


            $productCategoryDestroy =  new DestroyProductCategory(
                                                new DeleteImage($productCategory) );

            if($productCategoryDestroy->destroy()){
                // push index into index , to make VUE effect to delete
                array_push($this->list_index , $deleteItem['index']);
            }

        }
        // END TRANSACTION
        DB::commit();


        return $this;
    }

    private function result(){

        if($this->has_product){
            return response()->json(['message' => 'Esta Categoria de Produto possui Produtos Cadastrados ,  delete antes os Produtos para depois deletar esta Categoria .' ] , 400);
        }

        if($this->has_sub_category_products ){
            return response()->json(['message' => 'Esta Categoria de Notícia possui Sub Categoria de Produtos Cadastrados  ,  delete antes as Sub Categorias  para depois deletar esta Categoria .' ] , 400);
        }


        if(empty($this->list_index)){
            return response()->json(['message' => 'Erro, Comunique o Suporte' ] , 400);
        }

        // success
        return response()->json(['index'   => $this->list_index  ] , 200 );
    }
}
