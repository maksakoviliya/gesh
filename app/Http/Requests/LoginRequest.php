<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Http\Requests\LoginRequest as FortifyLoginRequest;

class LoginRequest extends FortifyLoginRequest
{
    protected function prepareForValidation()
    {
        if ($this->has('phone')) {
            $patterns = [
                '(',')',' ','-','+'
            ];
            $replacement = '';
            $phone = str_replace(
                $patterns,
                $replacement,
                $this->input('phone')
            );
            $this->merge([
                'phone' => $phone
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'email' => 'sometimes|required|string',
            'phone' => 'sometimes|required|string|phone:RU',
            'password' => 'required|string',
        ];
    }
}
