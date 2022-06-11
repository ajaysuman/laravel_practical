<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use DataTables;
use DB;
use response;
use Validator;

class CustomerController extends Controller
{ 
	// Display All Data
	public function index(Request $request){  
		 $data = DB::table('customers')->get();
		 foreach ($data as $value) {
		 }
		$url=asset("upload/$value->avatar"); 
 
 		if ($request->has('trashed')) {
	 		if ($request->ajax()) {
		          $data = DB::table('customers')->get();
		           return Datatables::of($data)
	                    ->addIndexColumn()
	                     ->addColumn('action', function($row){
	                    	 $id = $row->id;
	                          $btn = '<a href="javascript:void(0)" data-id="' . $id . '"class="edit btn btn-primary" id="edit">Edit</a>'." ".'<a href="javascript:void(0)" class="softdelete btn btn-danger btm-sm" id="softdelete">Delete</a>';
	                            return $btn;
	                    })
	                    ->rawColumns(['action'])
	                    ->make(true);
	  		}
	  	}else{
	  		if ($request->ajax()) {
		          $data = DB::table('customers')->get();
		           return Datatables::of($data) 
	                    ->addIndexColumn()
	               		  ->addColumn('action', function($row){
    					  	 $id = $row->id;
	                          $btn = '<a href="javascript:void(0)" data-id="' . $id . '"class="edit btn btn-primary" id="edit">Edit</a>'." ".'<a href="javascript:void(0)" class="softdelete btn btn-danger btm-sm" id="softdelete">Delete</a>';
	                            return $btn;
	                    })
	                    ->rawColumns(['action'])
	                    ->make(true);
	  		}
	  	}	
        return view('dashboard.customer');
	}

	// Add New Customer
	public function addCustomer(Request $request) {
		try {
		    $validation = Validator::make($request->all(), [
	      		'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
	     	]);
		     if($validation->passes())
		     {
		     	$image = $request->file('image');
		     	$new_name = rand() . '.' . $image->getClientOriginalExtension();
	     		$image->move(public_path('upload'), $new_name);
			 }
			 $shop_id = mt_rand(10, 99);
			 $newCustomer = new Customer();
			 $newCustomer->shop_id = $shop_id;
			 $newCustomer->first_name = $request->first_name;
			 $newCustomer->last_name = $request->last_name;
			 $newCustomer->city = $request->city;
			 $newCustomer->birthdate = $request->bdate;
			 $newCustomer->avatar = $new_name;

			 if($newCustomer->save() == 1){
				return response()->json([
		          'status'    => 200,
		          'message' => "Insert Customer Success..!!!!"
		        ]);
	 		}else{
	 			return response()->json([
		          'status'    => 400,
		          'message' => "Insert Faild..!!!!"
	        	]);
	 		}
		}catch (Exception $e) {
		     return $e->getMessage();
			}	
	}


	// For EditCustomer
	public function editCustomer(Request $request) {
		try {
			$customerData = Customer::where('id', $request->id)->get();
	 		return $customerData;
		}catch (Exception $e) {
		     return $e->getMessage();
			}

	}

	// FOR UPDATE
	public function updateCustomer(Request $request) {
		try{
			$validation = Validator::make($request->all(), [
		      'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
		    ]);
		     if($validation->passes())
		     {
		     	$image = $request->file('image');
		     	$new_name = rand() . '.' . $image->getClientOriginalExtension();
	     		$image->move(public_path('upload'), $new_name);
    	 		$data = Customer::where('id', $request->id)->update(array('first_name' => $request->first_name, 'last_name' => $request->last_name, 'city' => $request->city, 'birthdate' => $request->bdate,  'avatar' => $new_name));
		    }
	  		else{
					$data = Customer::where('id', $request->id)->update(array('first_name' => $request->first_name, 'last_name' => $request->last_name, 'city' => $request->city, 'birthdate' => $request->bdate));
	  		}
	     	return response()->json([
	          'status'    => 200,
	          'message' => "Update Data Success!!!!"
	        ]);

       } catch (Exception $e) {
		     return $e->getMessage();
			}
	 }
	
	// For Delete
	public function destroy(Request $request) {  
	  	try {
	 		 Customer::find($request->id)->delete();
		     return response()->json([
	          'status'    => 200,
	          'message' => "Delete Data Success!!!!"
	        ]);
	   }catch (Exception $e) {
		     return $e->getMessage();
			}
	}
}
