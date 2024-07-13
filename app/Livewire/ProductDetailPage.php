<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;

class ProductDetailPage extends Component
{
    public string $slug;

    public function mount(string $slug): void
    {
        $this->slug = $slug;
    }

    #[Title('Product Detail')]
    public function render()
    {
        return view('livewire.product-detail-page', ['product' => Product::where('slug', $this->slug)->first()]);
    }
}
