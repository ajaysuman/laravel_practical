<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Restaurant;

class RestaurantController extends Controller
{
   public function store(Request $request) {
      try{
          $validator = Validator::make($request->all(), [
              'restaurantname' => 'required|max:50',
              'restaurantcode' => 'required|max:50',
             	'restaurantdesc' => 'required|max:50',
             	'phone' => 'required|max:12|min:10',
             	'email' => 'required|email',
          ]);
   
          if ($validator->fails()) {
               return redirect('/')->withErrors($validator)->withInput();
          }

          // For Insert 
          $newRestaurrant = new Restaurant();

          $files = $request->image;
          $input['imagename'] = time().'.'.$files->getClientOriginalExtension();
          $folderpath = public_path('/upload');
          $files->move($folderpath, $input['imagename']);

          $newRestaurrant->restaurant_name = $request->restaurantname;
          $newRestaurrant->email = $request->email;
          $newRestaurrant->restaurant_code = $request->restaurantcode;
          $newRestaurrant->restaurant_desc = $request->restaurantdesc;
          // $newRestaurrant->image = $input['imagename'];
          $newRestaurrant->save();

          return redirect('/')->with('status', 'Add Restaurant Data Has Been inserted');



      }
       catch (Exception $e) {
          return $e->getMessage();
       }

   }
}
