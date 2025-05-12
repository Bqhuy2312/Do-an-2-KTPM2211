<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with('mainImage')->where('featured', true)->take(8)->get();
        $bestSellerProducts = Product::with('mainImage')->where('best_seller', true)->take(8)->get();

        return view('client.home', compact('featuredProducts', 'bestSellerProducts'));
    }
}