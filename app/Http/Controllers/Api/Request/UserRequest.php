<?php

/**
 * Created by PhpStorm.
 * User: Andrew K.
 * Date: 04.05.17
 * Time: 16:37
 */

namespace Api\Requests;

use Dingo\Api\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|max:100',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ];
    }
}



