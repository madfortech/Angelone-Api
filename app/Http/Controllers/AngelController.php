<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AngelController extends Controller
{
    // Step 1: Redirect user to Angel (FIXED)
   public function redirectToAngel()
    {
        $url = "https://smartapi.angelone.in/publisher-login"
            . "?api_key=" . config('services.angel.api_key')
            . "&redirect_uri=" . urlencode(config('services.angel.redirect') . '/callback')
            . "&state=live";

        return redirect($url);
    }


    // Step 2: Callback after login
    public function callback(Request $request)
    {
        $authToken = $request->query('auth_token');
        $feedToken = $request->query('feed_token');

        if (!$authToken) {
            return abort(403, 'Auth token missing');
        }

        Session::put('angel_auth_token', $authToken);
        Session::put('angel_feed_token', $feedToken);

        return redirect('/angel/profile');
    }

    // Step 3: Get user profile
    public function profile()
    {
        $jwt = Session::get('angel_auth_token');

        if (!$jwt) {
            return redirect('/')
                ->with('error', 'Angel session expired. Please login again.');
        }

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$jwt}",
            'Accept'        => 'application/json',
        ])->get(
            'https://apiconnect.angelone.in/rest/secure/angelbroking/user/v1/getProfile'
        );

        if (!$response->successful()) {
            return response()->json([
                'error'  => true,
                'status'=> $response->status(),
                'body'  => $response->json(),
            ]);
        }

        return response()->json($response->json());
    }

    // Step 4: Logout
    public function logout()
    {
        $jwt = Session::get('angel_auth_token');

        if ($jwt) {
            Http::withHeaders([
                'Authorization' => "Bearer {$jwt}",
                'Accept'        => 'application/json',
            ])->post(
                'https://apiconnect.angelone.in/rest/secure/angelbroking/user/v1/logout',
                [
                    'clientcode' => config('services.angel.client_id')
                ]
            );
        }

        Session::flush();

        return redirect('/')->with('message', 'Logged out from Angel One');
    }
}
