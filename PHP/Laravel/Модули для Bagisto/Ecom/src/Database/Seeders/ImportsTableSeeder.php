<?php

namespace Webkul\Ecom\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportsTableSeeder extends Seeder
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
                "id"                        => 1,
                "title"                     => "Импорт товаров",
                "code"                      => "goods",
                "ecom_import_type_id"       => 1,
                "ecom_import_interval_id"   => 2,
                "first_runtime"              => '2020-05-27 13:00:00',
                "last_import"               => null,
                "import_lastrun_status_id"  => 1,
                "enable"                    => 1,
            ],


        ];

        DB::table('ecom_imports')->insert($data);
    }
}
