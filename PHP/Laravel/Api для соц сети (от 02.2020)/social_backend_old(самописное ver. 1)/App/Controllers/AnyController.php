<?php


namespace App\Controllers;


use core\Controller;

class AnyController extends Controller
{
    public function indexAction(){
        $this->setData('angular_patch_dir', ANGULAR_PATH);
        return $this->render('layouts.any', $this->data);
    }
}