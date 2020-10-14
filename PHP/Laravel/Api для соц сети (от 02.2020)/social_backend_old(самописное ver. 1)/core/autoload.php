<?php

use core\Router;

require_once '../env.php';
require '../vendor/autoload.php';
require 'db.php';


include_once "helpers.php";
foreach ($helperList as $helper) {
    $path = '../App/Helpers/' . $helper . '.php';
    try {
        if (file_exists($path))
            require_once($path);
        else
            throw new Error($helper);
    } catch (Error $e) {
        if (DEBUG)
            echo("Helper <b>{$e->getMessage()}</b> not found in file: <b>{$e->getFile()}: {$e->getLine()}</b>");
    }
}
spl_autoload_register(function ($class) {
    $path = '../' . str_replace('\\', '/', $class) . '.php';
    echo "<pre>";
    print_r($path);
    echo "</pre>";
    try {

        if (file_exists($path))
            require_once($path);
        else
            throw new Error($class);
    } catch (Error $e) {

        if (DEBUG)
            echo("Class <b>{$e->getMessage()}</b> not found in file: <b>{$e->getFile()}: {$e->getLine()}</b>");
    }
});
include_once "../router/api.php";
include_once "../router/web.php";

$MAIN = Router::init();
if ($MAIN) {
    $action = Router::$route['action'];
    echo $MAIN->$action();
}


exit();
