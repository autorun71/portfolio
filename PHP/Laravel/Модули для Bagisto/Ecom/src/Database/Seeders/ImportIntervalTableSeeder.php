<?php

namespace Webkul\Ecom\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportIntervalTableSeeder extends Seeder
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
                "name"          => "Каждую минуту",
                "interval"      => 60,
            ],
            [
                "id"            => 2,
                "name"          => "Каждые 5 минут",
                "interval"      => 300,
            ],
            [
                "id"            => 3,
                "name"          => "Каждые 10 минут",
                "interval"      => 600,
            ],
            [
                "id"            => 4,
                "name"          => "Каждые 15 минут",
                "interval"      => 900,
            ],
            [
                "id"            => 5,
                "name"          => "Каждые 30 минут",
                "interval"      => 1800,
            ],
            [
                "id"            => 6,
                "name"          => "Каждый час",
                "interval"      => 3600,
            ],
            [
                "id"            => 7,
                "name"          => "Каждые 2 часа",
                "interval"      => 7200,
            ],
            [
                "id"            => 8,
                "name"          => "Каждые 6 часов",
                "interval"      => 21600,
            ],
            [
                "id"            => 9,
                "name"          => "Каждые 12 часов",
                "interval"      => 43200,
            ],
            [
                "id"            => 10,
                "name"          => "Раз в сутки",
                "interval"      => 86400,
            ],

        ];

        DB::table('ecom_import_intervals')->insert($data);
    }
}
