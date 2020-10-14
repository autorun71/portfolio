<?php


namespace App\Core\DB;


use App\Core\Main;
use App\Service\CLI;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Builder;

class Database {

    /** @var Capsule $capsule */
    public $capsule;
    /** @var Builder $capsule */
    public $schema;

    function __construct() {
        $this->capsule = new Capsule;

        $settings = Main::getSettings();

        if (empty($settings)) return;
        $settingsDB = $settings['connections']['value']['default'];

        $this->capsule->addConnection([
            'driver' => 'mysql',
            'host' => $settingsDB['host'],
            'database' => $settingsDB['database'],
            'username' => $settingsDB['login'],
            'password' => $settingsDB['password'],
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);
        // Setup the Eloquent ORM…
        $this->capsule->setAsGlobal();
        $this->schema = $this->capsule->schema();
        $this->capsule->bootEloquent();
    }

}