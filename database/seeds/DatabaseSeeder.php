<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         // $this->call(CategoriesnTableSeeder::class);
            $this->call(CommentsTableSeeder::class);
         // $this->call(PagesTableSeeder::class);
        //  $this->call(PostsTableSeeder::class);
         // $this->call(Roletableseeder::class);
    }
}
