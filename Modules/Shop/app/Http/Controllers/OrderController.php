<?php

namespace Modules\Shop\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Modules\Shop\Repositories\Front\Interfaces\AddressRepositoryInterfaces;
use Modules\Shop\Repositories\Front\Interfaces\CartRepositoryInterfaces;
use Illuminate\Support\Facades\Log; 

class OrderController extends Controller
{
    protected $addressRepository;
    protected $cartRepository;
    
    public function __construct(AddressRepositoryInterfaces $addressRepository, CartRepositoryInterfaces $cartRepository) {
        $this->addressRepository = $addressRepository;
        $this->cartRepository = $cartRepository;
    }
    public function checkout() {
        $user = Auth::user();

        $this->data['cart'] = $this->cartRepository->findByUser($user);
        $this->data['addresses'] = $this->addressRepository->findByUser($user);
        
        return $this->loadTheme('orders.checkout', $this->data);
    }

    public function shippingFee(Request $request) {
        $user = Auth::user();

        $address = $this->addressRepository->findByID($request->get('address_id'));
        $cart = $this->cartRepository->findByUser($user);
        
        $availableServices = $this->calculateShippingFee($cart, $address, $request->get('courier'));
        
        return $this->loadTheme('orders.available_services', ['services' => $availableServices]);
    }

    public function choosePackage(Request $request) {
        $user = Auth::user();

        $address = $this->addressRepository->findByID($request->get('address_id'));
        $cart = $this->cartRepository->findByUser($user);
        
        $availableServices = $this->calculateShippingFee($cart, $address, $request->get('courier'));

        $selectedPackage = null;
        if (!empty($availableServices)) {
            foreach ($availableServices as $service) {
                if ($service['service'] === $request->get('delivery_package')) {
                    $selectedPackage = $service;
                    continue;
                }
            }
        }

        if ($selectedPackage == null) {
            return [];
        }

        return [
            'shipping_fee' => number_format($selectedPackage['cost'], 0, ',', '.'),
            'grand_total' => number_format($cart->grand_total + $selectedPackage['cost'], 0, ',', '.'),
        ];
    }

    private function calculateShippingFee($cart, $address, $courier) {
        $shippingFees = [];

        try {
            
            $originId = (string) 4870;
            $destinationId = (string) $address->city;

            $response = Http::withHeaders([
                'key' => config('rajaongkir.api_key'),
            ])->asForm()->post('https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
                'origin' => $originId,
                'destination' => $destinationId,
                'weight' => (int)$cart->total_weight,
                'courier' => $courier,
            ]);

            $response->throw();
            $shippingFees = $response->json();
                    
        }   catch (\Exception $e) {           
            return [];
        }

        $availableServices = [];
            if (isset($shippingFees['meta']['status']) && $shippingFees['meta']['status'] === 'success' && !empty($shippingFees['data'])) {
            foreach ($shippingFees['data'] as $serviceDetail) { // Iterasi langsung di 'data'
                $availableServices[] = [
                    'service' => $serviceDetail['service'],
                    'description' => $serviceDetail['description'],
                    'etd' => $serviceDetail['etd'],
                    'cost' => $serviceDetail['cost'], // <-- Langsung ambil 'cost'
                    'courier' => $serviceDetail['code'], // Mengambil kode kurir dari respons
                    'address_id' => $address->id,
                ];
        }
    } else {
        // Log jika API response tidak sukses atau data kosong
        Log::warning('Komerce.id API did not return successful data: ', $shippingFees);
    }

    return $availableServices; 
    }

    public function searchDestination(Request $request) {
        $response = Http::withHeaders([
            'key' => config('rajaongkir.api_key'),
        ])->get('https://rajaongkir.komerce.id/api/v1/destination/domestic-destination', [
            'search' => $request->search,
            'limit' => 10,
            'offset' => 0,
        ]);

        return response()->json($response[
            'data'
        ]);
    }
}
