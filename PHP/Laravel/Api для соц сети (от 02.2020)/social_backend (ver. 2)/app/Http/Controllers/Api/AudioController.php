<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Music;
use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class AudioController extends Controller
{

    public $token, $audio;

    public function getAll(Request $request)
    {
        return response(Music::select([
            'id',
            'name',
            'artist',
            'duration'
        ])->get()->toJson())->header('Access-Control-Allow-Origin', '*');
    }


    public function getAudio(Request $request)
    {
        ini_set('memory_limit', '1024M');
        $client = new Client();
        try {
            $this->requestProcessing($request->query());
            $token = base64_decode($this->token);
            $audioId = base64_decode($this->audioId);
            $client->request('GET', getenv('APP_URL') . '/api/is_valid_token', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token
                ],
            ]);
            $tokenStatus = true;
        } catch (\Exception $e) {
            $tokenStatus = false;
        }

        if ($tokenStatus) {
            $music = new Music();
            $audio = $music->where('id', $audioId)->get()[0]->link;
        } else {
            $audio = "/uploads/music/unauth.mp3";
        }

        return response()->file($_SERVER['DOCUMENT_ROOT'] . "/.." . $audio);
    }

    public function requestProcessing($query)
    {


        $this->token = $query['t'];
        $this->audioId = $query['i'];

    }

    public function add(Request $request){


    }


}
