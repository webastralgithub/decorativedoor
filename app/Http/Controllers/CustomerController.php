<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\OrderDetails;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
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
        $user_id = $request->user_id;
        
        if(isset($user_id) && !empty($user_id)){
            $input = [
                'email' => $request->email,
                'name' => $request->name,
                'password' => Hash::make('javed1234'),
            ];
            $user = User::find($user_id);
            $user = $user->update([
                'email' => $request->email,
                'name' => $request->name,
                'password' => Hash::make('javed1234'),
            ]);
    
            $useraddress = User::find($user_id);
            $useraddress->address()->updateOrCreate(
                ['user_id' => $user_id],
                [
                    'street' => $request->street,
                    'city' => $request->city,
                    'state' => $request->state,
                    'country' => $request->country,
                    'zip_code' => $request->zipcode,
                ]
            );
            session()->put('assign_customer', $user_id);
        }else{
            $input = [
                'email' => $request->email,
                'name' => $request->name,
                'password' => Hash::make('javed1234'),
            ];
            $user = User::create($input);
    
            $lastinsertid = $user->id;
            $user = User::find($lastinsertid);
            $user->address()->updateOrCreate(
                ['user_id' => $lastinsertid],
                [
                    'street' => $request->street,
                    'city' => $request->city,
                    'state' => $request->state,
                    'country' => $request->country,
                    'zip_code' => $request->zipcode,
                ]
            );
            session()->put('assign_customer', $lastinsertid);
        }
        return redirect()->back()->with('success', 'Customer assign Succesfully!');
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
                'zipcode' => isset($checkuser->address->zip_code) ? $checkuser->address->zip_code : '',
            ];
            return json_encode($user_info);
        }else{
            return;
        }
        
    }
}
