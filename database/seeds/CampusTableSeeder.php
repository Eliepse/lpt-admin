<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CampusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('campuses')->updateOrInsert([
            'name' => 'aubervilliers',
        ]);

        DB::table('campuses')->updateOrInsert([
            'name' => 'belleville',
        ]);
    }
}
