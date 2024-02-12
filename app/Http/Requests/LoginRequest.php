<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Laravel\Fortify\Http\Requests\LoginRequest as FortifyLoginRequest;

class LoginRequest extends FortifyLoginRequest
{
    protected function prepareForValidation()
    {
        if ($this->input('phone')) {
            $patterns = [
                '(', ')', ' ', '-', '+',
            ];
            $replacement = '';
            $phone = str_replace(
                $patterns,
                $replacement,
                $this->input('phone')
            );
            $this->merge([
                'phone' => $phone,
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'email' => 'required_without:phone|string',
            'phone' => 'required_without:email|string|phone:RU',
            'password' => 'required|string',
        ];
    }
}
