<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Order Detail')]
class MyOrderDetailPage extends Component
{
    public $order;

    public function mount(Order $order)
    {
        $this->order = $order;
    }

    public function render()
    {

        return view('livewire.my-order-detail-page', ['order' => $this->order->load(['items.product', 'address'])]);
    }
}
