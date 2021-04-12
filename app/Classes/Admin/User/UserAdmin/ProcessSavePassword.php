<?php


namespace App\Classes\Admin\User\UserAdmin;
use App\Models\UserAdmin;
use Illuminate\Http\Request;

class ProcessSavePassword
{
    protected $request;
    protected $result;
    protected $user;

    public static function process(Request $request , UserAdmin $userAdmin  , $user){

        return  (new static)->handle($request , $userAdmin , $user );
    }

    private function handle($request , $userAdmin , $user){
        return   $this->setRequest($request)
                      ->setUser($user)
                      ->save($userAdmin)
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
    private function save($userAdmin)
    {
        $userAdmin->password = bcrypt($this->request['password']);
        $userAdmin->save();

        $this->result = true;
        return $this;
    }

    public function getResult(){

        // ERRO
        if(! $this->result ){
            return response()->json(null , 400);

        }

        // SUCESSO
        return response()->json(null ,  200 );
    }
}
