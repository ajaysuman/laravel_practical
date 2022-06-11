<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shops;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class shops_seeder extends Seeder
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
	            'name' => str::random(8),
	            'address' => str::random(80),
	        ]);
    	}
    }
}
