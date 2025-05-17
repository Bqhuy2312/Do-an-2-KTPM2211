@extends('admin.layout')

@section('content')
<div class="order-detail-page">
    <h1>Chi tiết đơn hàng #{{ $order->id }}</h1>

    <div class="order-info">
        <h3>Thông tin khách hàng</h3>
        <p><strong>Họ tên:</strong> {{ $order->user->name }}</p>
        <p><strong>Email:</strong> {{ $order->user->email }}</p>
        <p><strong>Số điện thoại:</strong> {{ $order->user->phone }}</p>
        <p><strong>Địa chỉ giao hàng:</strong> {{ $order->shipping_address }}</p>
        <p><strong>Ngày đặt hàng:</strong> {{ $order->created_at->format('d/m/Y H:i:s') }}</p>
        <p><strong>Hình thức thanh toán:</strong> {{ $order->payment_method }}</p>
        <p><strong>Ghi chú:</strong>{{ $order->note }}</p>
        <p><strong>Tổng tiền:</strong> {{ number_format($order->total, 0, ',', '.') }}đ</p>
        <p><strong>Trạng thái hiện tại:</strong>
            @if ($order->status == 'pending')
                <span style="color: #c2af00;">Đang chờ xử lý</span>
            @elseif ($order->status == 'processing')
                <span style="color: #007bff;">Đã xác nhận</span>
            @elseif ($order->status == 'delivered')
                <span style="color: #007a1d;">Đã hoàn thành</span>
            @elseif ($order->status == 'cancelled')
                <span style="color: #ff0000;">Đã hủy</span>
            @else
                <span style="color: #000;">Không xác định</span>
            @endif
        </p>
    </div>

    <hr>

    <h3>Sản phẩm trong đơn hàng</h3>
    <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Hình ảnh</th>
                <th>Màu sắc</th>
                <th>Kích thước</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Tổng</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->variant->product->name ?? 'Không có tên sản phẩm' }}</td>
                    <td>
                        @if ($item->variant->product->mainImage)
                            <img src="{{ asset($item->variant->product->mainImage->image_path) }}" alt="Ảnh sản phẩm" width="50">
                        @else
                            <span>Không có ảnh</span>
                        @endif
                    <td>{{ $item->variant->color ?? 'Không có màu' }}</td>
                    <td>{{ $item->variant->size ?? 'Không có size' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 0, ',', '.') }}đ</td>
                    <td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }}đ</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr>

    <h3>Cập nhật trạng thái đơn hàng</h3>
    @if (!in_array($order->status, ['delivered', 'cancelled']))
    <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}">
        @csrf
        <select name="status">
            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đã xác nhận</option>
            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Đã hoàn thành</option>
            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
        </select>
        <button type="submit">Cập nhật</button>
    </form>
    @else
        <p>Trạng thái đơn hàng không thể thay đổi.</p>
    @endif

    <br>
    <a href="{{ route('admin.orders.index') }}" class="action-btn">
        <button class="btn-detail-order">← Quay lại danh sách đơn hàng</button>
    </a>
</div>
@endsection
