<?php


namespace App\Api;


use App\Models\Test;
use core\Controller;

class TestController extends Controller
{

    function indexAction()
    {
        $time = time();
        $load = rand(4,12);
        $u = time() >= $time+$load;
        $testModel = new Test();
        $nTime = time();
        $data = $testModel->get()->toJson();
        while (!$u){
            if ($nTime != time()){
                $data2 = $testModel->get()->toJson();
                if ($data != $data2) break;
            }
            $u = (time() >= $time+$load ? true : false) ;
        }
        $data = $testModel->get()->toJson();

        return $data;
    }
}