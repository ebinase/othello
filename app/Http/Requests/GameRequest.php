<?php

namespace App\Http\Requests;

class GameRequest extends AbstractRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        switch($this->getCurrentActionMethod()) {
            case 'show':
                break;

            case 'process':
                $rules = [
                    'x'     => 'required',
                    'y'     => 'required',
                ];
                break;

            default:
                break;
        }
        return $rules;
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
        $params = [
            'x' => $this->input('x'),
            'y' => $this->input('y'),
        ];

        return $params;
    }
}
