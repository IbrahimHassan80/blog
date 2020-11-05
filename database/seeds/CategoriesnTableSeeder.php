<?php

use Illuminate\Database\Seeder;
use App\Models\categorie;
class CategoriesnTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        categorie::create(['name'=>'un_cateorized', 'status'=>1]);
        categorie::create(['name'=>'Natural', 'status'=>1]);
        categorie::create(['name'=>'Flowers', 'status'=>1]);
        categorie::create(['name'=>'Kitchen', 'status'=>0]);
    }
}
