<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassroomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('classrooms')->updateOrInsert([
            'name' => '学前班',
        ]);

        DB::table('classrooms')->updateOrInsert([
            'name' => '一年级',
        ]);

        DB::table('classrooms')->updateOrInsert([
            'name' => '二年级',
        ]);

        DB::table('classrooms')->updateOrInsert([
            'name' => '英语外教版',
        ]);
    }
}
