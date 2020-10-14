<?php

namespace Webkul\Region\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionPropsTableSeeder extends Seeder
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
                "name"          => "В городе",
                "code"          => "V_GORODE",
                "placeholder"   => "в Москве",
                "sort"          => 10,
                "enable"        => 1,
            ],
            [
                "id"            => 2,
                "name"          => "По городу",
                "code"          => "PO_GORODU",
                "placeholder"   => "по Москве",
                "sort"          => 20,
                "enable"        => 1,
            ],
            [
                "id"            => 3,
                "name"          => "Города",
                "code"          => "GORODA",
                "placeholder"   => "Москвы",
                "sort"          => 30,
                "enable"        => 1,
            ],
            [
                "id"            => 4,
                "name"          => "Город",
                "code"          => "GOROD",
                "placeholder"   => "Москва",
                "sort"          => 40,
                "enable"        => 1,
            ],
            [
                "id"            => 5,
                "name"          => "По [области]",
                "code"          => "OBLASTY",
                "placeholder"   => "Московской",
                "sort"          => 50,
                "enable"        => 1,
            ],
            [
                "id"            => 6,
                "name"          => "Карта",
                "code"          => "MAP",
                "placeholder"   => "",
                "sort"          => 60,
                "enable"        => 1,
            ],
            [
                "id"            => 7,
                "name"          => "Телефон (основной)",
                "code"          => "PHONE_MAIN",
                "placeholder"   => "+7(333)333-22-22",
                "sort"          => 70,
                "enable"        => 1,
            ],

        ];

        DB::table('region_props')->insert($data);
    }
}
