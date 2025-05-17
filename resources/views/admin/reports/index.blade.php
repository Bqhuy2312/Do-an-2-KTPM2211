@extends('admin.layout')

@section('content')
    <h1>Báo cáo thống kê</h1>

    <div class="report-section total-revenue">
        <h2>Tổng doanh thu</h2>
        <p class="revenue-amount">{{ number_format($totalRevenue, 0, ',', '.') }}đ</p>
    </div>

    <div class="report-section">
        <h2>Sản phẩm bán chạy</h2>
        <table>
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Hình ảnh</th>
                    <th>Danh mục</th>
                    <th>Số lượng bán</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bestSellingProducts as $item)
                    <tr>
                        <td>{{ $item->product->name ?? 'Sản phẩm đã xóa' }}</td>
                        <td>
                            @if($item->product && $item->product->mainImage)
                                <img src="{{ asset($item->product->mainImage->image_path) }}" alt="{{ $item->product->name }}" width="50">
                            @else
                                <img src="{{ asset('images/default-product.png') }}" alt="Hình ảnh không có" width="50">
                            @endif
                        </td>
                        <td>
                            @if($item->product && $item->product->category)
                                {{ $item->product->category->name }}
                            @else
                                Danh mục không có
                            @endif
                        </td>
                        <td>{{ $item->total_quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="report-section">
        <h2>Doanh thu theo tháng</h2>
        <table>
            <thead>
                <tr>
                    <th>Tháng</th>
                    <th>Doanh thu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($monthlyRevenue as $data)
                    <tr>
                        <td>Tháng {{ $data->month }}</td>
                        <td>{{ number_format($data->revenue, 0, ',', '.') }}đ</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection