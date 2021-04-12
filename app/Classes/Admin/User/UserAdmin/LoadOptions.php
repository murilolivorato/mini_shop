<?php


namespace App\Classes\Admin\User\UserAdmin;



use App\Classes\Utilities\DBStatus;


class LoadOptions
{
    protected $request;
    protected $user;
    protected $result;


    public static function load($request)
    {

        return (new static)->handle($request);
    }

    private function handle($request)
    {
        return $this->setRequest($request)
            ->process();
    }

    private function setRequest($request)
    {

        $this->request = $request;
        return $this;

    }

    private function process()
    {
        return response()->json([
            'status'               =>  DBStatus::getAll() ,
        ]);

    }
}
