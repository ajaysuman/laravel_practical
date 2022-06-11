<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class customer_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 500; $i++) { 
	    	Customer::create([
	            'first_name' => str_random(8),
	            'last_name' => str_random(8),
	            'avatar' => 'abc.jpg',
	            'city' => str_random(8),
	            'birthdate' => '2000-01-01',
	        ]);
    	}
    }
}
