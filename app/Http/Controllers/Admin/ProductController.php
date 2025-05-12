<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $query = Product::with('category', 'mainImage');

        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }
    
        $products = $query->get();
        $categories = Category::all();
    
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(ProductRequest $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'featured' => 'boolean',
            'best_seller' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'colors' => 'required|array',
            'colors.*' => 'string',
            'sizes' => 'required|array',
            'sizes.*' => 'string',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:0'
        ]);

        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'featured' => $validated['featured'] ?? false,
            'best_seller' => $validated['best_seller'] ?? false,
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName); // Lưu vào public/images
            $imagePath = 'images/' . $imageName;
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $imagePath,
                'is_main' => true
            ]);
        }

        foreach ($validated['colors'] as $index => $color) {
            ProductVariant::create([
                'product_id' => $product->id,
                'color' => $color,
                'size' => $validated['sizes'][$index],
                'quantity' => $validated['quantities'][$index]
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được thêm thành công!');
    }

    public function edit($id)
    {
        $product = Product::with('images', 'variants')->findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'featured' => 'boolean',
            'best_seller' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'colors' => 'required|array',
            'colors.*' => 'string',
            'sizes' => 'required|array',
            'sizes.*' => 'string',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:0'
        ]);

        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'featured' => $validated['featured'] ?? false,
            'best_seller' => $validated['best_seller'] ?? false,
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName); // Lưu vào public/images
            $imagePath = 'images/' . $imageName; // Đường dẫn tương đối

            if ($product->mainImage) {
                Storage::disk('public')->delete($product->mainImage->image_path);
                $product->mainImage->delete();
            }

            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $imagePath,
                'is_main' => true
            ]);
        }

        $existingVariants = $product->variants->keyBy(function ($variant) {
            return $variant->color . '-' . $variant->size;
        });

        foreach ($validated['colors'] as $index => $color) {
            $size = $validated['sizes'][$index];
            $quantity = $validated['quantities'][$index];

            $key = $color . '-' . $size;

            if ($existingVariants->has($key)) {
                $variant = $existingVariants->get($key);
                $variant->update(['quantity' => $quantity]);
                $existingVariants->forget($key);
            } else {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'color' => $color,
                    'size' => $size,
                    'quantity' => $quantity,
                ]);
            }
        }

        foreach ($existingVariants as $variant) {
            $isUsed = OrderItem::where('product_variant_id', $variant->id)->exists();

            if (!$isUsed) {
                $variant->delete();
            } else {
                $variant->update(['quantity' => 0]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được cập nhật thành công!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $variantIds = $product->variants->pluck('id');

        OrderItem::whereIn('product_variant_id', $variantIds)->delete();

        $product->variants()->delete();

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Sản phẩm và các biến thể liên quan đã được xóa thành công!');
    }
}