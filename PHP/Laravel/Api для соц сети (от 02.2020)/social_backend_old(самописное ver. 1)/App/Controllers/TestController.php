<?php


namespace App\Controllers;


use App\Models\Test;
use core\Controller;
use core\Router;

class TestController extends Controller
{

    function indexAction()
    {
        $testModel = new Test();

        $this->setData('tests', $testModel->get()->toJson());


        return $this->render('pages.test.page');
    }
}