<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class AbstractRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    abstract function authorize();

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract function rules();

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    abstract function messages();

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    abstract function attributes();

    /**
     * 現在呼び出されているコントローラのアクション名を取得する
     *
     * @return string
     */
    public function getCurrentActionMethod()
    {
        list($controller, $method) = explode('@', \Route::currentRouteAction());
        return $method;
    }
}
