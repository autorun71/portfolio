<?php


namespace App\Core\DB;


use Closure;
use Illuminate\Database\Capsule\Manager;

class Schema
{

    static function create($table, Closure $callback)
    {
        Manager::schema()->create($table, $callback);
    }

    /**
     * Drop a table from the schema.
     *
     * @param string $table
     * @return void
     */
    static function drop($table)
    {
        Manager::schema()->drop($table);
    }

    /**
     * Drop a table from the schema if it exists.
     *
     * @param string $table
     * @return void
     */
    static function dropIfExists($table)
    {
        Manager::schema()->dropIfExists($table);
    }


    /**
     * Rename a table on the schema.
     *
     * @param string $from
     * @param string $to
     * @return void
     */
    static function rename($from, $to)
    {
        Manager::schema()->rename($from, $to);
    }
}