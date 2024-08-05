<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Models\Address;
use App\Models\Order;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Title;
use Livewire\Component;
#[Title('Checkout')]
class CheckoutPage extends Component
{
    public $first_name;
    public $last_name;
    public $phone;
    public $street_address;
    public $city;
    public $state;
    public $zip_code;
    public $payment_method;

    public function mount()
    {
        $cartItems = CartManagement::getCartItemsFromCookie();

        if (count($cartItems) ===0){
            return redirect('/products');
        }
    }
    public function placeOrder()
    {
        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|digits_between:11,13',
            'street_address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip_code' => 'required|string',
            'payment_method' => 'required',
        ]);

        $cartItems = CartManagement::getCartItemsFromCookie();
        $lineItems = [];
        foreach ($cartItems as $cartItem){
            $lineItems[] =[
                'price_data'=>[
                    'currency' => 'usd',
                    'unit_amount' => $cartItem['unit_amount'] * 100,
                    'product_data'=>[
                        'name' => $cartItem['name'],
                    ]
                ],
                'quantity' => $cartItem['quantity'],
            ];
            $order = Order::create([
                'user_id' => auth()->id(),
                'grand_total' => CartManagement::calculateTotalAmount($cartItems),
                'payment_method' => $this->payment_method,
                'payment_status' => 'pending',
                'status' => 'new',
                'currency' => 'usd',
                'shipping_amount' => 0,
                'shipping_method' => 'none',
                'notes' => 'order placed by' . auth()->user()->name
            ]);

            $address =Address::create([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'phone' => $this->phone,
                'city' => $this->city,
                'street_address' => $this->street_address,
                'state' => $this->state,
                'zip_code' => $this->zip_code,
            ]);

            $redirectUrl = '';

            if ($this->payment_method === 'stripe'){
//                Strip::setApiKey(env('STRIPE_SECRET'));
//                $sessionCheckout = Session::create([
//                    'payment_method_types' => ['card'],
//                    'customer_email' => auth()->user()->email,
//                    'line_items' => $lineItems,
//                    'mode' => 'payment',
//                    'success_url' => route('success'),
//                    'cancel_url' => route('cancel'),
//                ]);
//                $redirectUrl = $sessionCheckout->url;
            }else{
                $redirectUrl = route('success');
            }

            $address->update([
                'order_id' => 1
            ]);

            $order->items()->createMany($cartItems);
            CartManagement::clearCartItems();

            return redirect($redirectUrl);

        }

    }
    public function render()
    {
        $orderItems = CartManagement::getCartItemsFromCookie();
        $grandTotal = CartManagement::calculateTotalAmount($orderItems);

        return view('livewire.checkout-page',[
            'orderItems' => $orderItems,
            'grand_total' => $grandTotal,
        ]);
    }
}
