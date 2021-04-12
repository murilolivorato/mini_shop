<?php


namespace App\Http\Requests\Admin;


use App\Classes\Auth\VerifyAuthRequest;
use App\Rules\VerifyUniqueField;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize()
    {
        // VERIFY USER ADMIN
        return VerifyAuthRequest::verifyAdmin();

    }

    /**
     * Get the validation rules that apply to the request.
     * new ValidadeCNPJ() ,
     * @return array
     */
    public function rules()
    {
        $stock_action = [
            'qty_stock'            => 'required' ,
            'subtract_stock'       => 'required' ,

        ];

        $general = [
            'title'                       => ['required', (new VerifyUniqueField())->setPrimarId($this->id)->setModel('products')],
            'category_id'                 => 'required|min:1',
            'sub_category_id'             => 'required|min:1',
            'manufacture_id'              => 'required|min:1',
            'description'                 => 'required',
            'meta_tag_title'              => 'required',
            'meta_tag_description'        => 'required',
            'meta_key_words'              => 'required',
            'number_qty_unity'            => 'required',
            'weight_unity'                => 'required',
            'weight'                      => 'required' ,
            'ship_by_company'             => 'required' ,
            'in_stock'                    => 'required' ,
            'action_out_stock'            => 'required'

        ];

        if($this->in_stock == "has_in_stock"){
            return array_merge ($general , $stock_action);
         }

        return $general;

        /*
         *  'dimension_length'            => 'required',
            'dimension_width'             => 'required',
            'dimension_height'            => 'required',
         'min_quantity'                => 'required',
            'max_quantity'                => 'required',
         */

    }
}
