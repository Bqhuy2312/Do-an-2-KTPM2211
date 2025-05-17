<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $newProducts = Product::orderBy('created_at', 'desc')->take(5)->get();

    $bestSellerProducts = Product::select('products.*', DB::raw('SUM(order_items.quantity) as total_sold'))
        ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
        ->join('order_items', 'product_variants.id', '=', 'order_items.product_variant_id')
        ->groupBy('products.id')
        ->orderBy('total_sold', 'desc')
        ->take(5)
        ->get();

    return view('client.home', compact('newProducts', 'bestSellerProducts'));
    }
}