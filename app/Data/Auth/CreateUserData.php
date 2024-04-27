<?php

namespace App\Data\Auth;

use OpenApi\Attributes as OAT;
use Spatie\LaravelData\Data;

#[Oat\Schema(schema: 'createUser')]
class CreateUserData extends Data
{
    public function __construct(
        #[OAT\Property(type: 'string')]
        public string $name,
        #[OAT\Property(type: 'string')]
        public string $email,
        #[OAT\Property(type: 'string')]
        public string $password,

    ) {
    }

    public static function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
        ];
    }
}
