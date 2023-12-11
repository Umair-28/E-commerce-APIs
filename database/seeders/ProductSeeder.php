<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Product::truncate();

        DB::table('products')->insert([
            'name'=>'Product1',
            'description'=>'Description for Product 1',
            'price'=>'10.20'
        ]);

        DB::table('products')->insert([
            'name'=>'Product2',
            'description'=>'Description for Product 2',
            'price'=>'15.10'
        ]);

        DB::table('products')->insert([
            'name'=>'Product3',
            'description'=>'Description for Product 3',
            'price'=>'30.00'
        ]);
    }
}
