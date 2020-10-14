<?php

namespace Webkul\Ecom\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportTypeTableSeeder extends Seeder
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
                "name"          => "Ecom",
                "code"          => "ecom",
                "enable"        => 1,
            ],
            [
                "id"            => 2,
                "name"          => "Seo",
                "code"          => "seo",
                "enable"        => 1,
            ],
            [
                "id"            => 3,
                "name"          => "Основные",
                "code"          => "main",
                "enable"        => 1,
            ],
            [
                "id"            => 4,
                "name"          => "Yandex",
                "code"          => "yandex",
                "enable"        => 1,
            ],


        ];

        DB::table('ecom_import_types')->insert($data);
    }
}
