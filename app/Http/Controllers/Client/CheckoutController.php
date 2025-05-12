<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::with('items.productVariant.product')->where('user_id', Auth::id())->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        $subtotal = $cart->items->sum(function ($item) {
            return $item->productVariant->product->price * $item->quantity;
        });

        return view('client.checkout', compact('cart', 'subtotal'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric|digits_between:9,11',
            'shipping_address' => 'required|string|max:500',
            'payment_method' => 'required|in:cod,credit_card,e_wallet',
            'note' => 'nullable|string|max:1000',
        ]);

        $cart = Cart::with('items.productVariant')->where('user_id', Auth::id())->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        $subtotal = $cart->items->sum(function ($item) {
            return $item->productVariant->product->price * $item->quantity;
        });
        $shipping_fee = 30000;
        $total = $subtotal + $shipping_fee;

        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => $total,
            'shipping_fee' => $shipping_fee,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'shipping_address' => $request->shipping_address,
            'phone' => $request->phone,
            'note' => $request->note,
        ]);

        foreach ($cart->items as $item) {
            $order->items()->create([
                'product_variant_id' => $item->product_variant_id,
                'quantity' => $item->quantity,
                'price' => $item->productVariant->product->price,
            ]);

            $item->productVariant->decrement('quantity', $item->quantity);
        }

        $cart->items()->delete();
        $cart->delete();

        return redirect()->route('checkout.success')->with('success', 'Đơn hàng của bạn đã được đặt thành công!');
    }

    public function success()
    {
        return view('client.success');
    }
}