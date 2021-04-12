<?php


namespace App\Http\Requests\Admin;

use App\Classes\Auth\VerifyAuthRequest;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;



class GalleryImageUploadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    public function authorize()
    {
        // VERIFY USER ADMIN
        return VerifyAuthRequest::verifyAdmin();


    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image.*' =>  'required | max:12000',
        ];
    }
}
