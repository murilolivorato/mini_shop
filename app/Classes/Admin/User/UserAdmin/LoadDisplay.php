<?php


namespace App\Classes\Admin\User\UserAdmin;
use App\Models\UserAdmin;
use App\Classes\Helper\SetQuery;

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
        $name                  = $this->request->input('name');
        $email                 = $this->request->input('email');

        $result  = UserAdmin::select([ 'id', 'status', 'email', 'password', 'folder' ])

            // WHEN NAME
            ->when($name , function ($query) use ($name) {
                // HAS NO DISTANCE
                $query->whereHas('AdminInfo', function ($query) use ($name) {
                    return $query->where('name', 'like' , '%' .  $name .'%'  );
                });
            })

            // WHEN EMAIL
            ->when($email , function ($query) use ($email) {
                return $query->where('email', 'like' , '%' .  $email .'%'  );
            })

            // IMAGE
            ->with([ 'ImageProfile' => function($query) {
                $query->select('id' , 'user_admin_id' , 'image');
            } ])

            // IMAGE GALLERY
            ->with([ 'AdminInfo' => function($query) {
                $query->select('id' , 'name' , 'last_name' , 'user_admin_id' );
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
