<?php

namespace Modules\Shop\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Shop\Models\Address; 
use Illuminate\Support\Facades\Log;



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
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address1' => 'required|string',
            'address2' => 'nullable|string|max:255',
            'province' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postcode' => 'required|string|max:10',
            'address_type_label' => 'required|in:Rumah,Kantor'
        ]);

        $user = Auth::user();

        $isPrimary = ($request->get('address_type_label') === 'Kantor') ? 1 : 0;

        $validatedData['label'] = $request->get('address_type_label');
        $validatedData['is_primary'] = $isPrimary;
        $validatedData['user_id'] = $user->id;

        unset($validatedData['address_type_label']);

        if ($validatedData['is_primary'] == 1) {
            $user->addresses()->where('is_primary', 1)->update(['is_primary' => 0]);
        } else {
            if ($user->addresses()->where('is_primary', 1)->doesntExist()) {
                $validatedData['is_primary'] =1;
            }
        }

        $user->addresses()->create($validatedData);

        return redirect()->route('profile.show')->with('success', 'Alamat baru berhasil ditambahkan!');
    }
    

    public function setPrimary(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Nonaktifkan semua primary address user ini
        Auth::user()->addresses()->where('is_primary', 1)->update(['is_primary' => 0]);

        // Jadikan alamat ini primary
        $address->is_primary = 1;
        $address->save();

        return redirect()->route('profile.show')->with('success', 'Alamat utama berhasil diubah.');
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
