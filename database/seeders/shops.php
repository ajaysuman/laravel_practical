<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shops;

class shops extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         for ($i=0; $i < 1000; $i++) { 
	    	Shops::create([
	            'name' => str_random(8),
	            'address' => str_random(80),
	        ]);
    	}
    }
}
