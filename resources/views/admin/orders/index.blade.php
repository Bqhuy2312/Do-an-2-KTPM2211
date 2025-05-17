@extends('admin.layout')

@section('content')
    <h2>Quản lý đơn hàng</h2>

    <table>
        <thead>
            <tr>
                <th>Mã đơn</th>
                <th>Tên khách hàng</th>
                <th>Trạng thái</th>
                <th>Ngày đặt</th>
                <th>Hành động</th>
            </tr>
        </thead>

        @php
            $statusMap = [
                'pending' => 'Đang chờ xử lý',
                'processing' => 'Đã xác nhận',
                'delivered' => 'Đã hoàn thành',
                'cancelled' => 'Đã hủy',
            ];
        @endphp

        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name ?? 'Ẩn danh' }}</td>
                    <td>{{ $statusMap[$order->status] ?? 'Không xác định' }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="action-btn">
                            <button class="btn-detail-order">Chi tiết</button>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
