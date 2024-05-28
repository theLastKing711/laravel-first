<?php

namespace App\Http\Controllers;

use App\Data\Auth\CreateUserData;
use App\Data\Auth\LoginUser;
use App\Data\Auth\UserData;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OAT;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    /**
     * Get Token
     */
    #[
        OAT\Get(
            path: '/sanctum/csrf-cookie',
            tags: ['sanctum'],
            //        parameters: [
            ////            new OAT\HeaderParameter(
            ////                name: 'X-CSRF-TOKEN',
            ////            ),
            //            new OAT\HeaderParameter(
            //                name: 'Origin',
            //                schema: new OAT\Schema(
            //                    type: 'string',
            //                    default: 'http://127.0.0.1:8000/'
            //                )
            //            ),
            //            new OAT\HeaderParameter(
            //                name: 'Accept',
            //                schema: new OAT\Schema(
            //                    type: 'string',
            //                    default: 'application/json',
            //                )
            //            ),
            //        ],
            responses: [
                new OAT\Response(
                    response: 200,
                    description: 'The User was successfully created',
                    headers: [
                        new OAT\Header(
                            header: 'Set-Cookie',
                            schema: new OAT\Schema(
                                type: 'string',
                            )
                        )
                    ]
                )
            ],
        ),
        OAT\SecurityScheme(
            securityScheme: "basicAuth",
            type: "apiKey",
        )
    ]
    public function getToken()
    {
        return ['asldkj'];
    }
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
    public function login(Request $request, LoginUser $data)
    {

        if (Auth::attempt($data->all())) {
            $request->session()->regenerate();
            return Auth::user();
        }

        return [];
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
