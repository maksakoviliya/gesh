<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * @throws ValidationException
     */
    public function create(array $input): Model
    {
        if (Arr::has($input, 'phone')) {
            $patterns = [
                '(', ')', ' ', '-', '+',
            ];
            $replacement = '';
            $input['phone'] = str_replace(
                $patterns,
                $replacement,
                Arr::get($input, 'phone')
            );
            if ($phone = Arr::get($input, 'phone')) {
                $phone = new PhoneNumber($phone, 'RU');
                $input['phone'] = $phone->formatE164();
            }
        }
        Validator::make($input, [
            'phone' => ['sometimes', 'required', 'string', 'max:20', 'unique:users', 'phone:RU'],
            'email' => ['sometimes', 'required', 'string', 'email', 'max:255', 'unique:users'],
            'name' => ['required', 'string', 'max:255'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return User::query()->create([
            'phone' => Arr::get($input, 'phone'),
            'email' => Arr::get($input, 'email'),
            'name' => Arr::get($input, 'name'),
            'password' => Hash::make($input['password']),
        ]);
    }
}
