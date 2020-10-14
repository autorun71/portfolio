<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required',
        ]);
        $validateData['password'] = bcrypt($validateData['password']);

        $user = User::create($validateData);

        $accessToken = $user->createToken('authToken')->accessToken;
        return response(['user' => $user, 'access_token' => $accessToken])->header('Access-Control-Allow-Origin', '*');


    }

    public function login(Request $request)
    {

        if ($json = $request->json()->all()){
           if (!empty($json['email']) && !empty($json['password'])){
               $loginData = $json;
           }
        }else{
            $loginData = $request->validate([
                'email' => 'email|required',
                'password' => 'required',
            ]);
        }




        if (!auth()->attempt($loginData)){
            return response(['message' => 'Invalid credentials']);

        }
        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken]);

    }

    public function options(){
        return response('');

    }

    public function tokenClear(Request $request){
        $query = $request->query();
        if (empty($query) || empty($query['id']) || empty($query['token'])) return 'false';


        \DB::table('oauth_access_tokens')
            ->where('user_id', (int) $query['id'])
            ->where('revoked', '<>', 1)
            ->update(['revoked' => 1]);

        return 'true';
    }
}
