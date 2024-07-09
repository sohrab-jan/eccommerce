<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

class ProductsPage extends Component
{
    #[Title('Product')]
    public function render()
    {
        return view('livewire.products-page');
    }
}
