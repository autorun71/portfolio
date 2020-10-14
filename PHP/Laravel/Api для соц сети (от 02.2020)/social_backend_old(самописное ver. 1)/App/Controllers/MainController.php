<?php


namespace App\Controllers;


use core\Controller;

class MainController extends Controller
{

    public function indexAction()
    {
        return $this->render('pages.home.page');
    }

    public function test()
    {
        return '12312';
    }
}