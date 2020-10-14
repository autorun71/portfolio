<?php

namespace Webkul\Ecom\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                "id"            => 1,
                "name"          => "Ожидает запуска",
                "color"         => "thistle"
            ],
            [
                "id"            => 2,
                "name"          => "В очереди",
                "color"         => "#8da2e0"
            ],
            [
                "id"            => 3,
                "name"          => "Запущен",
                "color"         => "royalblue"
            ],

            [
                "id"            => 4,
                "name"          => "Выполнен",
                "color"         => "green"
            ],

            [
                "id"            => 5,
                "name"          => "Ошибка",
                "color"         => "red"
            ],



        ];

        DB::table('ecom_import_lastrun_statuses')->insert($data);
    }
}
