<?php

namespace Modules\Shop\Repositories\Front;

use App\Models\User;
use Modules\Shop\Models\Address;
use Modules\Shop\Repositories\Front\Interfaces\AddressRepositoryInterfaces;

class AddressRepository implements AddressRepositoryInterfaces {

    public function findByUser(User $user)
    {
        return Address::where('user_id', $user->id)
        ->orderByDesc('is_primary')
        ->orderBy('created_at')
        ->get();
    }

    public function findByID(string $id)
    {
        return Address::findOrFail($id);
    }
}