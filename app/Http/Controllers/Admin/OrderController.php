<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
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

        if (in_array($order->status, ['delivered', 'cancelled'])) {
            return redirect()->route('admin.orders.show', $order->id)
            ->with('error', 'Không thể thay đổi trạng thái của đơn hàng đã hoàn thành hoặc đã hủy.');
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

    public function report()
    {
        $completedOrders = Order::where('status', 'delivered')->get();

        $totalRevenue = Order::where('status', 'delivered')
            ->select(DB::raw('SUM(total - 30000) as total_revenue'))
            ->value('total_revenue');

        $bestSellingProducts = OrderItem::select('product_variants.product_id', DB::raw('SUM(order_items.quantity) as total_quantity'))
            ->join('product_variants', 'order_items.product_variant_id', '=', 'product_variants.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivered')
            ->groupBy('product_variants.product_id')
            ->orderBy('total_quantity', 'desc')
            ->take(5)
            ->with('product') 
            ->get();

        $monthlyRevenue = Order::select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total - 30000) as revenue'))
            ->where('status', 'delivered')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get();

        return view('admin.reports.index', compact('totalRevenue', 'bestSellingProducts', 'monthlyRevenue'));
    }
}
