<?php

namespace App\Http\Controllers;

use App\Facades\CFiles;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request){
        /*$file = $request->file('file');
        if (!empty($file)) {
            $arFile = CFiles::makeFileArray($file);
            echo "<pre>";
            print_r(CFiles::upload($arFile));
            echo "</pre>";;
        }*/

        echo "<pre>";
        print_r(CFiles::getById(2));
        echo "</pre>";
        return view('test');
    }
}
