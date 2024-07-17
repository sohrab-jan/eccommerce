<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;

class ProductDetailPage extends Component
{
    public string $slug;
    public $quantity = 1;

    public function mount(string $slug): void
    {
        $this->slug = $slug;
    }

    public function increment()
    {
        $this->quantity++;
    }
    public function decrement()
    {
        if ($this->quantity > 1){
            $this->quantity--;
        }
    }

    #[Title('Product Detail')]
    public function render()
    {
        return view('livewire.product-detail-page', ['product' => Product::where('slug', $this->slug)->first()]);
    }
}
