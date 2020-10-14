<?php

namespace Webkul\Ecom\Database\Seeders;

use Illuminate\Database\Seeder;
use Webkul\Category\Database\Seeders\DatabaseSeeder as CategorySeeder;
use Webkul\Attribute\Database\Seeders\DatabaseSeeder as AttributeSeeder;
use Webkul\Core\Database\Seeders\DatabaseSeeder as CoreSeeder;
use Webkul\User\Database\Seeders\DatabaseSeeder as UserSeeder;
use Webkul\Customer\Database\Seeders\DatabaseSeeder as CustomerSeeder;
use Webkul\Inventory\Database\Seeders\DatabaseSeeder as InventorySeeder;
use Webkul\CMS\Database\Seeders\DatabaseSeeder as CMSSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(ImportTypeTableSeeder::class);
        $this->call(ImportStatusTableSeeder::class);
        $this->call(ImportIntervalTableSeeder::class);
        $this->call(ImportsTableSeeder::class);

    }
}