<?php

namespace Modules\Shop\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Shop\Models\Address; 

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('shop::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('shop::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address1' => 'required|string',
            'province' => 'required|string',
            'city' => 'required|string',
            'postcode' => 'required|string|max:10',
        ]);

        Auth::user()->addresses()->create($request->all());

        return redirect()->route('profile.show')->with('success', 'Alamat baru berhasil ditambahkan!');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('shop::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('shop::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $address->delete();
        return redirect()->route('profile.show')->with('success', 'Alamat berhasil dihapus.');
    }
}
