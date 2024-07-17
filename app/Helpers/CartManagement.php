<?php

namespace App\Helpers;

use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class CartManagement
{
    //add item to cart
    public static function addItemToCart($productId, $quantity)
    {
        $cart_items = self::getCartItemsFromCookie();

        $existingItem = null;

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $productId) {
                $existingItem = $key;
                break;
            }
        }

        if ($existingItem !== null) {
            $cart_items[$existingItem]['quantity'] = $quantity ?? $cart_items[$existingItem]['quantity']++;
            $cart_items[$existingItem]['total_amount'] = $cart_items[$existingItem]['quantity'] * $cart_items[$existingItem]['unit_amount'];
        } else {
            $product = Product::where('id', $productId)->first(['id', 'name', 'price', 'images']);

            if ($product) {
                $cart_items[] = [
                    'product_id' => $productId,
                    'name' => $product->name,
                    'image' => $product->images[0],
                    'quantity' => $quantity ?? 1,
                    'unit_amount' => $product->price,
                    'total_amount' => $product->price,
                ];
            }
        }
        self::addCartItemToCookie($cart_items);

        return count($cart_items);
    }

    //remove item from cart
    public static function removeCartItem($productId)
    {
        $cartItems = self::getCartItemsFromCookie();

        foreach ($cartItems as $key => $item) {
            if ($item['product_id'] == $productId) {
                unset($cartItems[$key]);
            }
        }
        self::addCartItemToCookie($cartItems);
    }

    //add cart item to cookie
    public static function addCartItemToCookie($cartItems)
    {
        Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);
    }

    //clear cart items from cookie
    public static function clearCartItems()
    {
        Cookie::queue(Cookie::forget('cart_items'));
    }

    //get all cart items from cookie
    public static function getCartItemsFromCookie()
    {
        $cartItems = json_decode(Cookie::get('cart_items'), true);
        if (! $cartItems) {
            $cartItems = [];
        }

        return $cartItems;
    }

    //    increment item quantity
    public static function incrementQuantityToCartItem($productId)
    {
        $cartItems = self::getCartItemsFromCookie();

        foreach ($cartItems as $key => $item) {
            if ($item['product_id'] == $productId) {
                $cartItems[$key]['quantity']++;
                $cartItems[$key]['total_amount'] = $cartItems[$key]['quantity'] * $cartItems[$key]['unit_amount'];
            }
        }
        self::addCartItemToCookie($cartItems);

        return $cartItems;
    }

    //    decrement item quantity
    public static function decrementQuantityToCartItem($productId)
    {
        $cartItems = self::getCartItemsFromCookie();

        foreach ($cartItems as $key => $item) {
            if ($item['product_id'] == $productId) {
                if ($cartItems[$key]['quantity'] > 1) {
                    $cartItems[$key]['quantity']--;
                    $cartItems[$key]['total_amount'] = $cartItems[$key]['quantity']
                        * $cartItems[$key]['unit_amount'];
                }
            }
        }
        self::addCartItemToCookie($cartItems);

        return $cartItems;
    }
    //    calculate grand total

    public static function calculateTotalAmount($items)
    {
        return array_sum(array_column($items, 'total_amount'));
    }
}
