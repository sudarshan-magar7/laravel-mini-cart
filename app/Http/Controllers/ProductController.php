<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = [
            ['id' => 1, 'name' => 'Laptop', 'price' => 999.99],
            ['id' => 2, 'name' => 'Smartphone', 'price' => 100.99],
            ['id' => 3, 'name' => 'Headphones', 'price' => 25.99],
            ['id' => 1, 'name' => 'Desktop', 'price' => 250.99],
            ['id' => 2, 'name' => 'Iphone', 'price' => 500.99],
            ['id' => 3, 'name' => 'CPU', 'price' => 700.99],
        ];

        return view('products.index', compact('products'));
    }
}