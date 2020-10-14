<?php


namespace App\Controllers;


use core\Controller;

class Error404Controller extends Controller
{
    function indexAction(){
        header("HTTP/1.0 404 Not Found");
        return '<h1>404 Not Found</h1>';
    }
}