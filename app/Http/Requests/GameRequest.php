<?php

namespace App\Http\Requests;

use JetBrains\PhpStorm\ArrayShape;

class GameRequest extends AbstractRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
         return match ($this->getCurrentActionMethod()) {
            default => []
        };
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [];
    }

    public function getProcessParams()
    {
        if (!empty($this->input('action'))) {
            return null;
        }

        $params = [
            'x' => $this->input('x'),
            'y' => $this->input('y'),
        ];

        return $params;
    }
}
