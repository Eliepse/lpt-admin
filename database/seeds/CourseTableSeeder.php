<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('courses')->updateOrInsert([
            'name' => '学前班',
        ]);

        DB::table('courses')->updateOrInsert([
            'name' => '一年级',
        ]);

        DB::table('courses')->updateOrInsert([
            'name' => '二年级',
        ]);

        DB::table('courses')->updateOrInsert([
            'name' => '英语外教版',
        ]);
    }
}
