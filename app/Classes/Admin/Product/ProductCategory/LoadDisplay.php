<?php


namespace App\Classes\Admin\Product\ProductCategory;

use App\Models\ProductCategory;

class LoadDisplay
{
    protected $request;
    protected $user;
    protected $paginateNumber = 20;
    protected $page = null;


    public static function load($request){

        return   (new static)->handle($request);
    }

    private function handle($request){
        return   $this->setRequest($request)
                      ->processQuery();
    }

    private function setRequest($request){

        $this->request = $request;
        return $this;
    }


    // PROCESSING FORM
    public function processQuery()
    {
        $title                 = $this->request->input('title');

        $result  = ProductCategory::select([ 'id' , 'title' , 'url_title' , 'user_id' , 'meta_tag_description' ,'meta_key_words' , 'created_at'])

            // QUANDO NOME
           ->when($title, function ($query) use ($title) {
                return $query->where('title', 'like' , '%' .  $title .'%'  );
            })

            // COUNT
           ->withCount('Products')
           ->withCount('SubCategory')

            // IMAGE
            ->with([ 'Image' => function($query) {
                $query->select('id' , 'category_id' , 'image' , 'title');
            } ])

           ->orderBy('created_at', 'DESC')
           ->paginate($this->paginateNumber , ['*'], 'page', $this->page );


        return  [
            'pagination' => [
                'total'         => $result->total(),
                'per_page'      => $result->perPage(),
                'current_page'  => $result->currentPage(),
                'last_page'     => $result->lastPage(),
                'from'          => $result->firstItem(),
                'to'            => $result->lastItem()
            ],
            'data'             => $result->items()
        ];




    }
}
