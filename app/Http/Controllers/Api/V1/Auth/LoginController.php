<?php

namespace App\Http\Controllers\Api\V1\Auth;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LaravelJsonApi\Core\Document\Error;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ClientException;
use LaravelJsonApi\Laravel\Http\Controllers\JsonApiController;

class LoginController extends JsonApiController
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
            // TODO: This should be removed in production since it is a security measure
            // Without this it crashes on local development
            $http = new Client(['verify' => false]);

            $client = DB::table('oauth_clients')->where('password_client', 1)->first();

            $response = $http->post(route('passport.token'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => $client->id,
                    'client_secret' => $client->secret,
                    'username' => $request->email,
                    'password' => $request->password,
                    'scope' => '',
                ],
            ]);

            return json_decode((string) $response->getBody(), true);
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
