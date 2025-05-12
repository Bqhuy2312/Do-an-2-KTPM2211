<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::with('items.productVariant.product.mainImage')
            ->where('user_id', Auth::id())
            ->first();

        return view('client.cart', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'color' => 'required|string',
            'size' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $variant = ProductVariant::where('product_id', $request->product_id)
            ->where('color', $request->color)
            ->where('size', $request->size)
            ->first();

        if (!$variant) {
            return redirect()->back()->with('error', 'Biến thể sản phẩm không tồn tại.');
        }

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_variant_id', $variant->id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_variant_id' => $variant->id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1',
        ]);
    
        $cart = Cart::where('user_id', Auth::id())->first();
    
        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng không tồn tại.');
        }

        foreach ($request->quantities as $productVariantId => $quantity) {
            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_variant_id', $productVariantId)
                ->first();
    
            if ($cartItem) {
                $availableStock = $cartItem->productVariant->quantity;
                if ($quantity > $availableStock) {
                    return redirect()->route('cart.index')->with('error', 'Số lượng sản phẩm không đủ.');
                }

                $cartItem->quantity = $quantity;
                $cartItem->save();
            }
        }
    
        return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được cập nhật.');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:product_variants,id',
        ]);

        $cart = Cart::where('user_id', Auth::id())->first();

        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng không tồn tại.');
        }

        CartItem::where('cart_id', $cart->id)
            ->where('product_variant_id', $request->product_id)
            ->delete();

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
    }
}