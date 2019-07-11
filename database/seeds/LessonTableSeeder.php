<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LessonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Languages
         */

        // Chinese

        DB::table('lessons')->insert([
            'name' => '中文课',
            'description' => '《LPT新编教材识字本》1-14课',
            'category' => 'language',
        ]);

        DB::table('lessons')->insert([
            'name' => '中文课',
            'description' => '《LPT新编教材识字本》15-28课',
            'category' => 'language',
        ]);

        // English

        DB::table('lessons')->insert([
            'name' => '英文课',
            'description' => '25%外教课',
            'category' => 'language',
        ]);

        DB::table('lessons')->insert([
            'name' => '英文课',
            'description' => '50%外教课',
            'category' => 'language',
        ]);

        DB::table('lessons')->insert([
            'name' => '英文课',
            'description' => '75%外教课',
            'category' => 'language',
        ]);

        DB::table('lessons')->insert([
            'name' => '英文课',
            'description' => '100%外教课',
            'category' => 'language',
        ]);

        /*
         * Creative
         */

        DB::table('lessons')->insert([
            'name' => '手工课',
            'description' => '',
            'category' => 'creative',
        ]);

        /*
         * Science
         */

        DB::table('lessons')->insert([
            'name' => '科学小实验',
            'description' => '',
            'category' => 'science',
        ]);
    }
}
