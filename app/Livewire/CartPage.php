<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

class CartPage extends Component
{
    #[Title('Cart')]
    public function render()
    {
        return view('livewire.cart-page');
    }
}
