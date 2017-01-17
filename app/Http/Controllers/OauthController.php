<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class OauthController extends Controller
{

    public function redirect()
    {
            $query = http_build_query([
                'client_id' => '2',
                'redirect_uri' => 'http://oauthclient.dev:8081/auth/callback',
                'response_type' => 'code',
                'scope' => '',
            ]);

            return redirect('http://todos.dev:8080/oauth/authorize?'.$query);

    }

    public function redirect_implicit()
    {
        $query = http_build_query([
            'client_id' => '2',
            'redirect_uri' => 'http://localhost/auth/callback',
            'response_type' => 'token', //implicit
            'scope' => '',
        ]);

        return redirect('http://todos.dev:8080/oauth/authorize?'.$query);

    }

    public function callback(Request $request)
    {

            $http = new Client;

            $response = $http->post('http://todos.dev:8080/oauth/token', [
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'client_id' => '2',
                    'client_secret' => 'shxYoRL9xqEuvRFWR0xW8UWBocRbV8H6RY9huJch',
                    'redirect_uri' => 'http://oauthclient.dev:8081/auth/callback',
                    'code' => $request->input('code'),
                ],
            ]);

            $json = json_decode((string) $response->getBody(), true);

            $access_token = $json['access_token'];

            //TODO guardar tokens en persistència (base de dades)
            //SERVER: guardar a base de dades ok!
            //Client: app mòbil

            $response2 = $http->get('http://todos.dev:8080/api/v1/task', [
                'headers' => [
                    'X-Requested-With' => 'XMLHttpRequest',
                    'Authorization' => 'Bearer '.$access_token
                ],
            ]);

            $json2 = json_decode((string) $response2->getBody(), true);

            dd($json2);
    }

}
