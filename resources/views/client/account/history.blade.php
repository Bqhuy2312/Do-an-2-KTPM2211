@extends('client.layout')

@section('title', 'Lịch sử đặt hàng')

@section('content')
<div class="account-page">
    <div class="account-container">
        <div class="account-sidebar">
            <div class="user-info">
                <div class="avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="user-name">{{ Auth::user()->name }}</div>
            </div>
            
            <nav class="account-menu">
                <ul>
                    <li class="active">
                        <a href="{{ route('account.profile') }}">
                            <i class="fas fa-user"></i> Thông tin cá nhân
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('account.history') }}">
                            <i class="fas fa-history"></i> Lịch sử đặt hàng
                        </a>
                    </li>
                    <li>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Đăng xuất
                        </a>
                        <form id="logout-form" method="POST" action="{{ route('account.logout') }}" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </nav>
        </div>

        @php
            $statusMap = [
                'pending' => 'Đang chờ xử lý',
                'processing' => 'Đã xác nhận',
                'delivered' => 'Đã hoàn thành',
                'cancelled' => 'Đã hủy',
            ];
        @endphp
        
        <div class="account-content">
            <h2>Lịch sử đặt hàng</h2>
            
            @if ($orders->isEmpty())
                <p>Bạn chưa có đơn hàng nào.</p>
            @else
                <table class="order-history-table">
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Ngày đặt</th>
                            <th>Trạng thái</th>
                            <th>Tổng tiền</th>
                            <th>Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                <td>{{ $statusMap[$order->status] }}</td>
                                <td>{{ number_format($order->total, 0, ',', '.') }} đ</td>
                                <td>
                                    <a href="#" onclick="toggleOrderDetails({{ $order->id }})">Xem chi tiết</a>
                                </td>
                            </tr>
                            <tr id="order-details-{{ $order->id }}" style="display: none;">
                                <td colspan="5">
                                    <table class="order-items-table">
                                        <thead>
                                            <tr>
                                                <th>Tên sản phẩm</th>
                                                <th>Hình ảnh</th>
                                                <th>Màu sắc</th>
                                                <th>Kích thước</th>
                                                <th>Số lượng</th>
                                                <th>Giá</th>
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
                                                    <td>{{ $item->variant->size ?? 'Không có kích thước' }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>{{ number_format($item->price, 0, ',', '.') }} đ</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

<script>
    function toggleOrderDetails(orderId) {
        const detailsRow = document.getElementById(`order-details-${orderId}`);
        detailsRow.style.display = detailsRow.style.display === 'none' ? 'table-row' : 'none';
    }
</script>
@endsection