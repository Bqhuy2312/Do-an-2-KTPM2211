<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
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

        return view('client.products', compact('products'));
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

    public function filter(Request $request)
    {
        $query = Product::query();

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        if ($request->has('price_min') && $request->price_min != '') {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->has('price_max') && $request->price_max != '') {
            $query->where('price', '<=', $request->price_max);
        }

        if ($request->has('sort')) {
            if ($request->sort == 'price_asc') {
                $query->orderBy('price', 'asc');
            } elseif ($request->sort == 'price_desc') {
                $query->orderBy('price', 'desc');
            }
        }

        $products = $query->paginate(8);

        return view('client.products', compact('products'));
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