<?php


namespace App\Http\Controllers\Api;


class TokenController
{

    public function isValid()
    {
        return response()->json(['valid' => true, 'user' => auth()->user()]);
    }
}
