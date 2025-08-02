<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    private function getProducts()
    {
        return [
            1 => ['id' => 1, 'name' => 'Laptop', 'price' => 999.99],
            2 => ['id' => 2, 'name' => 'Smartphone', 'price' => 599.99],
            3 => ['id' => 3, 'name' => 'Headphones', 'price' => 199.99],
        ];
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        $products = $this->getProducts();
        $cartItems = [];
        $grandTotal = 0;

        foreach ($cart as $id => $quantity) {
            if (isset($products[$id])) {
                $product = $products[$id];
                $subtotal = $product['price'] * $quantity;
                $cartItems[] = [
                    'id' => $id,
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $quantity,
                    'subtotal' => $subtotal
                ];
                $grandTotal += $subtotal;
            }
        }

        return view('cart.index', compact('cartItems', 'grandTotal'));
    }

    public function add(Request $request, $id)
    {
        $products = $this->getProducts();
        
        if (!isset($products[$id])) {
            return redirect()->back()->with('error', 'Product not found!');
        }

        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        session()->put('cart', $cart);
        
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            $cart[$id] = $request->quantity;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Cart updated successfully!');
        }

        return redirect()->back()->with('error', 'Product not found in cart!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product removed from cart!');
        }

        return redirect()->back()->with('error', 'Product not found in cart!');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Cart cleared successfully!');
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        session()->forget('cart');
        return redirect()->route('products.index')->with('success', 'Thank you for your purchase! Your order has been placed successfully.');
    }
}