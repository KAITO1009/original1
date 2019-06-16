<?php

use Illuminate\Database\Seeder;

class BookPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1;$i<=10; $i++){
            DB::table('book_posts')->insert([
                'user_id' => 3,
                'title' => 'test title'.$i,
                'content' => 'test content'.$i,
                'advertisement' => 'test advertisement'.$i,
                ]);
        }
    }
}
