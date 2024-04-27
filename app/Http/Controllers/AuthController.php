<?php

namespace App\Http\Controllers;

use App\Data\Auth\CreateUserData;
use App\Data\Auth\UserData;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use OpenApi\Attributes as OAT;


class AuthController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    #[OAT\Post(
        path: '/auth/signUp',
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\JsonContent(ref: '#/components/schemas/createUser'),
        ),
        tags: ['auth'],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'The User was successfully created',
                content: new OAT\JsonContent(ref: '#/components/schemas/user'),
            )
        ],
    )]
    public function signUp(CreateUserData $data)
    {

        $user = User::create($data->all());

        $userDto = UserData::fromModel($user);

        return $userDto;
    }

    /**
     * Login the user.
     */
    #[OAT\Post(
        path: '/auth/login',
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\JsonContent(ref: '#/components/schemas/loginUser'),
        ),
        tags: ['auth'],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'The User was successfully created',
                content: new OAT\JsonContent(ref: '#/components/schemas/user'),
            )
        ],
    )]
    public function login(Request $request, CreateUserData $data)
    {

        if (Auth::attempt($data->all())) {
            $request->session()->regenerate();
        }
        
        return Auth::user();
    }

    /**
     * Logout the signed in user.
     */
    #[OAT\Post(
        path: '/auth/logout',
//        requestBody: new OAT\RequestBody(
//            required: true,
//            content: new OAT\JsonContent(ref: '#/components/schemas/loginUser'),
//        ),
        tags: ['auth'],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'The User was successfully logged out',
//                content: new OAT\JsonContent(ref: '#/components/schemas/user'),
            )
        ],
    )]
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

    }

}
