<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items.variant.product', 'user'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {

        $order = Order::findOrFail($id);

        if (in_array($order->status, ['confirmed', 'cancelled'])) {
            return redirect()->back()->with('error', 'Không thể cập nhật trạng thái đơn hàng đã được xác nhận hoặc hủy.');
        }

        $order->status = $request->status;
        $order->save();

        if ($request->status === 'confirmed') {
            foreach ($order->orderItems as $item) {
                $variant = ProductVariant::find($item->product_variant_id);
                if ($variant) {
                    $variant->quantity -= $item->quantity;
                    $variant->save();
                }
            }
        }

        return redirect()->route('admin.orders.index')->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
    }
}
