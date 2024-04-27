<?php

namespace App\Data\Auth;

use App\Models\User;
use OpenApi\Attributes as OAT;
use Spatie\LaravelData\Data;

#[Oat\Schema(schema: 'loginUser')]
class LoginUser extends Data
{
    public function __construct(
        #[OAT\Property(type: 'string')]
        public string $email,
        #[OAT\Property(type: 'string')]
        public string $password,
    ) {
    }

    public static function fromModel(User $user): self
    {
        return new self(
            email: $user->email,
            password: $user->password,
        );
    }
}
