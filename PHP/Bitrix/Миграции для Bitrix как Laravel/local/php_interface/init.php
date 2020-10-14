<?php
use Arrilot\BitrixModels\ServiceProvider;
require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

ServiceProvider::register();
ServiceProvider::registerEloquent();
$db = new \App\Core\DB\Database();
