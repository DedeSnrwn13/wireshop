<?php

namespace App\Http\Livewire\Shop;

use Midtrans\Snap;
use Midtrans\Config;
use App\Facades\Cart;
use Livewire\Component;

class Checkout extends Component
{
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $address;
    public $city;
    public $postal_code;
    public $formCheckout;
    public $snapToken;

    protected $listeners = [
        'emptyCart' => 'emptyCartHandler'
    ];

    public function mount()
    {
        $this->formCheckout = true;
    }

    public function render()
    {
        return view('livewire.shop.checkout');
    }

    public function checkout()
    {
        $this->validate([
            'first_name' => 'required|min:2',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'address' => 'required|max:200',
            'city' => 'required',
            'postal_code' => 'required|numeric',
        ]);

        $cart = Cart::get()['products'];
        $amount = array_sum(
            array_column($cart, 'price')
        );

        $customerDetails = [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'postal_code' => $this->postal_code,
        ];

        $transactionDetails = [
            'order_id' => uniqid(),
            'gross_amount' => $amount,
        ];

        $payload = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
        ];

        $this->formCheckout = false;

        // Set your Merchant Server Key
        Config::$serverKey = config('services.midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Config::$isProduction = config('services.midtrans.isProduction');
        // Set sanitization on (default)
        Config::$isSanitized = config('services.midtrans.isSanitized');
        // Set 3DS transaction for credit card to true
        Config::$is3ds = config('services.midtrans.is3ds');

        $snapToken = Snap::getSnapToken($payload);

        $this->snapToken = $snapToken;
    }

    public function emptyCartHandler()
    {
        Cart::clear();
        $this->emit('cartClear');
    }
}
