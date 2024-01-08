<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('frontend.customer.index', [
            'products' => Product::latest()->paginate(env('RECORD_PER_PAGE', 10))
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = $request->id;
        $email = $request->email;
        $address_type = $request->address_type;
        $state = $request->state;
        $street = $request->street;
        $city = $request->city;
        $country = $request->country;
        $zipcode = $request->zipcode;

        if(isset($user_id) && !empty($user_id)){
        

        }else{

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function checkuser(Request $request){

        $checkuser = User::with('address')->where('email', $request->email)->first();
        if(isset($checkuser) && !empty($checkuser)){
            $user_info = [
                'id' => $checkuser->id,
                'name' => $checkuser->name,
                'address_type' => isset($checkuser->address->address_type) ? $checkuser->address->address_type : '',
                'state' => isset($checkuser->address->state) ? $checkuser->address->state : '',
                'street' => isset($checkuser->address->street) ? $checkuser->address->street : '',
                'city' => isset($checkuser->address->city) ? $checkuser->address->city : '',
                'country' => isset($checkuser->address->country) ? $checkuser->address->country : '',
                'zipcode' => isset($checkuser->address->zipcode) ? $checkuser->address->zipcode : '',
            ];
            return json_encode($user_info);
        }else{
            return;
        }
        
    }
}
