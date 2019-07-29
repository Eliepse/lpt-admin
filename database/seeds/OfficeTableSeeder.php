<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfficeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('offices')->updateOrInsert([
            'name' => 'aubervilliers',
        ]);

        DB::table('offices')->updateOrInsert([
            'name' => 'belleville',
        ]);
    }
}
