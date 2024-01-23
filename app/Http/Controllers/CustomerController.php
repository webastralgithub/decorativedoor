<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\UserCompany;
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
            'products' => Product::latest()->paginate(env('RECORD_PER_PAGE', 50))
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
        $request->validate([
            'email' => 'required',
            'name' => 'required',
            'password' => 'required',
            'phone' => 'required',
            'dob' => 'required',
            'gender' => 'required',

        ]);

        // dd($request->all());
        $user_id = $request->user_id;

        if (isset($user_id) && !empty($user_id)) {

            $user = User::find($user_id);
            $user = $user->update([
                'email' => $request->email,
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'dob' => $request->dob,
                'gender' => $request->gender,
            ]);

            $useraddress = User::find($user_id);
            $user->assignRole('Customer');
            $useraddress->address()->updateOrCreate(
                ['user_id' => $user_id],
                [
                    'address_type' => $request->address_type,
                    'street' => $request->street,
                    'city' => $request->city,
                    'state' => $request->state,
                    'country' => $request->country,
                    'zip_code' => $request->zipcode,
                    'billing_address_type' => $request->billing_address_type,
                    'billing_street' => $request->billing_street,
                    'billing_city' => $request->billing_city,
                    'billing_state' => $request->billing_state,
                    'billing_country' => $request->billing_country,
                    'billing_zipcode' => $request->billing_zipcode,
                    'notes' => $request->notes,
                ]
            );

            $useraddress->usercompany()->updateOrCreate(
                ['user_id' => $user_id],
                [
                    'company_name' => $request->company_name,
                    'company_address' => $request->company_address,
                    'company_phone' => $request->company_phone,
                    'company_email' => $request->company_email,
                    'industory_type' => $request->industory_type,
                    'company_website' => $request->company_website,
                    'registration_no' => $request->registration_no,
                    'gst' => $request->gst,
                ]
            );
            session()->put('assign_customer', $user_id);
        } else {
            $input = [
                'email' => $request->email,
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'dob' => $request->dob,
                'gender' => $request->gender,
            ];
            $user = User::create($input);

            $lastinsertid = $user->id;
            $user = User::find($lastinsertid);
            $user->assignRole('Customer');
            $user->address()->updateOrCreate(
                ['user_id' => $lastinsertid],
                [
                    'address_type' => $request->address_type,
                    'street' => $request->street,
                    'city' => $request->city,
                    'state' => $request->state,
                    'country' => $request->country,
                    'zip_code' => $request->zipcode,
                    'billing_address_type' => $request->billing_address_type,
                    'billing_street' => $request->billing_street,
                    'billing_city' => $request->billing_city,
                    'billing_state' => $request->billing_state,
                    'billing_country' => $request->billing_country,
                    'billing_zipcode' => $request->billing_zipcode,
                    'notes' => $request->notes,
                ]
            );

            $user->usercompany()->updateOrCreate(
                ['user_id' => $user_id],
                [
                    'company_name' => $request->company_name,
                    'company_address' => $request->company_address,
                    'company_phone' => $request->company_phone,
                    'company_email' => $request->company_email,
                    'industory_type' => $request->industory_type,
                    'company_website' => $request->company_website,
                    'registration_no' => $request->registration_no,
                    'gst' => $request->gst,
                ]
            );
            session()->put('assign_customer', $lastinsertid);
        }
        if (session()->has('cart')) {
            return redirect()->route('cart')->with('success', 'Customer assign Succesfully!');
        } else {
            return redirect()->route('home')->with('success', 'Customer assign Succesfully!');
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

    public function checkuser(Request $request)
    {

        $checkuser = User::with('address', 'usercompany')->where('email', $request->email)
            ->whereHas('roles', function ($query) {
                $query->where('name', 'Customer');
            })->first();
        if (isset($checkuser) && !empty($checkuser)) {
            $user_info = [
                'id' => $checkuser->id ?? '',
                'name' => $checkuser->name ?? '',
                'password' => $checkuser->password ?? '',
                'phone' => $checkuser->phone ?? '',
                'dob' => $checkuser->dob ?? '',
                'gender' => $checkuser->gender ?? '',

                'address_type' => $checkuser->address->address_type ?? '',
                'street' => $checkuser->address->street ?? '',
                'city' => $checkuser->address->city ?? '',
                'state' => $checkuser->address->state ?? '',
                'country' => $checkuser->address->country ?? '',
                'zip_code' => $checkuser->address->zipcode ?? '',
                'billing_address_type' => $checkuser->address->billing_address_type ?? '',
                'billing_street' => $checkuser->address->billing_street ?? '',
                'billing_city' => $checkuser->address->billing_city ?? '',
                'billing_state' => $checkuser->address->billing_state ?? '',
                'billing_country' => $checkuser->address->billing_country ?? '',
                'billing_zipcode' => $checkuser->address->billing_zipcode ?? '',
                'notes' => $checkuser->address->notes ?? '',

                'company_name' => $checkuser->usercompany->company_name ?? '',
                'company_address' => $checkuser->usercompany->company_address ?? '',
                'company_phone' => $checkuser->usercompany->company_phone ?? '',
                'company_email' => $checkuser->usercompany->company_email ?? '',
                'industory_type' => $checkuser->usercompany->industory_type ?? '',
                'company_website' => $checkuser->usercompany->company_website ?? '',
                'registration_no' => $checkuser->usercompany->registration_no ?? '',
                'gst' => $checkuser->usercompany->gst ?? '',
            ];
            return json_encode($user_info);
        } else {
            return;
        }
    }

    public function assignCartCustomer(Request $request)
    {
        $user_id = $request->user_id;
        session()->put('assign_customer', $user_id);
        return response()->json(['success' => 'Customer Assign Successfully!!']);
    }
}
