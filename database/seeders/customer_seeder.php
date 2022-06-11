<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

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
	            'shop_id' => random_int(1,100),
	            'first_name' => str::random(8),
	            'last_name' => str::random(8),
	            'avatar' => 'abc.jpg',
	            'city' => str::random(8),
	            'birthdate' => Carbon::parse('2000-01-01')
	        ]);
    	}
    }
}
