<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class Product2Controller extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query();

        if ($request->has('category') && $request->category != '') {
            $products->where('category_id', $request->category);
        }

        if ($request->has('sort')) {
            if ($request->sort == 'price_asc') {
                $products->orderBy('price', 'asc');
            } elseif ($request->sort == 'price_desc') {
                $products->orderBy('price', 'desc');
            }
        }

        $products = $products->paginate(8);
        $categories = Category::all();

        return view('client.products', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::with(['images', 'variants'])->findOrFail($id);

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->take(4)
            ->get();

        return view('client.product-detail', compact('product', 'relatedProducts'));
    }

    public function search(Request $request)
    {
        $query = trim($request->input('q'));

        if (empty($query)) {
            return redirect()->back()->with('error', 'Vui lòng nhập từ khóa tìm kiếm.');
        }

        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->paginate(10);

        return view('client.search', compact('products', 'query'));
    }
}