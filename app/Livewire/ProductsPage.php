<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partial\Navbar;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsPage extends Component
{
    use LivewireAlert;
    use WithPagination;

    #[Url]
    public $selected_categories = [];

    #[Url]
    public $selected_brands = [];

    #[Url]
    public $featured;

    #[Url]
    public $sale;

    #[Url]
    public $price_range = 30000;

    #[Url]
    public $sort = 'latest';

    public function addToCart($productId)
    {
        $totalCount = CartManagement::addItemToCart($productId);
        $this->dispatch('update-cart-count', totalCount: $totalCount)->to(Navbar::class);

        $this->alert('success', 'Product added to cart successfully!', [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true,
        ]);
    }

    #[Title('Product')]
    public function render()
    {
        $productQuery = Product::where('is_active', true);

        if (! empty($this->selected_categories)) {
            $productQuery->whereIn('category_id', $this->selected_categories);
        }
        if (! empty($this->selected_brands)) {
            $productQuery->whereIn('brand_id', $this->selected_brands);
        }
        if ($this->featured) {
            $productQuery->where('is_featured', 1);
        }
        if ($this->sale) {
            $productQuery->where('on_sale', 1);
        }
        if ($this->sort === 'latest') {
            $productQuery->latest();
        }
        if ($this->sort === 'price') {
            $productQuery->orderBy('price');
        }
        if ($this->price_range && $this->price_range = ! 30000) {
            $productQuery->whereBetween('price', [0, $this->price_range]);
        }

        return view('livewire.products-page', [
            'products' => $productQuery->paginate(9),
            'brands' => Brand::where('is_active', 1)->get(['id', 'name', 'slug']),
            'categories' => Category::where('is_active', 1)->get(['id', 'name', 'slug']),
        ]);
    }
}
