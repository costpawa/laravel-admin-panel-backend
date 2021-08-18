<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Models\User;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\GuzzleException;
use LaravelJsonApi\Core\Document\Error;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return mixed
     * @throws GuzzleException
     */
    public function __invoke(Request $request)
    {
        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);
            $credentials = $request->only(['email', 'password']);
            $loginRequest = new Request($credentials);
            return (new LoginController)($loginRequest);
        } catch (ClientException $e) {
            $error = json_decode($e->getResponse()->getBody()->getContents());
            return Error::fromArray([
                'title' => 'Bad Request',
                'detail' => $error->message,
                'status' => '400',
            ]);
        }
    }
}