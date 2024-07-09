<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

class MyOrderPage extends Component
{
    #[Title('Order')]
    public function render()
    {
        return view('livewire.my-order-page');
    }
}
