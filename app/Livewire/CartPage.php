<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partial\Navbar;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;

class CartPage extends Component
{
    public $cartItems = [];

    public $grandTotal;

    public $quantity = 1;

    public function removeItem(Product $product)
    {
        $this->cartItems = CartManagement::removeCartItem($product->id);
        $this->grandTotal = CartManagement::calculateTotalAmount($this->cartItems);
    }

    public function increment(Product $product)
    {
        $this->cartItems = CartManagement::incrementQuantityToCartItem($product->id);
        $this->grandTotal = CartManagement::calculateTotalAmount($this->cartItems);
    }

    public function decrement(Product $product)
    {
        $this->cartItems = CartManagement::decrementQuantityToCartItem($product->id);
        $this->grandTotal = CartManagement::calculateTotalAmount($this->cartItems);
    }

    public function mount()
    {
        $this->cartItems = CartManagement::getCartItemsFromCookie();
        $this->grandTotal = CartManagement::calculateTotalAmount($this->cartItems);

        $this->dispatch('update-cart-count', totalCount: count($this->cartItems))
            ->to(Navbar::class);
    }

    #[Title('Cart')]
    public function render()
    {
        return view('livewire.cart-page');
    }
}
