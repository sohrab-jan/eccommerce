<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partial\Navbar;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

class ProductDetailPage extends Component
{
    use LivewireAlert;

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
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart($productId)
    {
        $totalCount = CartManagement::addItemToCart($productId, $this->quantity);
        $this->dispatch('update-cart-count', totalCount: $totalCount)->to(Navbar::class);

        $this->alert('success', 'Product added to cart successfully!', [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true,
        ]);
    }

    #[Title('Product Detail')]
    public function render()
    {
        return view('livewire.product-detail-page', ['product' => Product::where('slug', $this->slug)->first()]);
    }
}
