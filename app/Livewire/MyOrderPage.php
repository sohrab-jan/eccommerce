<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class MyOrderPage extends Component
{
    use WithPagination;

    #[Title('My Orders')]
    public function render()
    {
        $orders = Order::where('user_id', auth()->id())->latest()->paginate(10);

        return view('livewire.my-order-page', compact('orders'));
    }
}
