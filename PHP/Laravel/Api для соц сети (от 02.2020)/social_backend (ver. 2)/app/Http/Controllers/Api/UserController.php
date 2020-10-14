<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function getUser(Request $request){
        $id = $request->id;
        $id = (int)$id;
        if ($id > 0){
            return response(User::where('id', $id)->get()->toJson());
        }

    }
}
