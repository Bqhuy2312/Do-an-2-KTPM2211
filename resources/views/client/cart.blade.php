@extends('client.layout')

@section('content')
    <div class="cart-page">
        <h1 class="page-title">Giỏ hàng của bạn</h1>

    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

        <div class="cart-container">
            @if ($cart && $cart->items->count() > 0)
                <div class="cart-items">    
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Tổng</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart->items as $item)
                                <tr>
                                    <td class="product-info">
                                        <img src="{{ asset($item->productVariant->product->mainImage->image_path ?? 'images/default-product.jpg') }}" alt="{{ $item->productVariant->product->name }}">
                                        <div>
                                            <h3>{{ $item->productVariant->product->name }}</h3>
                                            <p>Màu: {{ $item->productVariant->color }} / Size: {{ $item->productVariant->size }}</p>
                                        </div>
                                    </td>
                                    <td class="product-price">{{ number_format($item->productVariant->product->price, 0, ',', '.') }}đ</td>
                                    <td class="product-quantity">
                                        <form method="POST" action="{{ route('cart.update') }}">
                                            @csrf
                                            <div class="quantity-selector">
                                                <input type="number" name="quantities[{{ $item->productVariant->id }}]" value="{{ $item->quantity }}" min="1" style="width: 60px; text-align: center;">
                                            </div>
                                            <div class="cart-actions">
                                                <button type="submit" class="update-btn">Cập nhật</button>
                                            </div>
                                        </form>                                   
                                            <input type="hidden" name="product_id" value="{{ $item->productVariant->id }}">
                                            
                                    </td>
                                    <td class="product-total">{{ number_format($item->productVariant->product->price * $item->quantity, 0, ',', '.') }}đ</td>
                                    <td class="product-remove">
                                        <form method="POST" action="{{ route('cart.remove') }}">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $item->productVariant->id }}">
                                            <button type="submit" class="remove-btn"><i class="fas fa-times"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="cart-actions">
                        <a href="{{ route('client.products.index') }}" class="continue-shopping">Tiếp tục mua sắm</a>
                    </div>
                </div>
                
                <div class="cart-summary">
                    <h3>Tóm tắt đơn hàng</h3>
                    <div class="summary-details">
                        <div class="summary-row">
                            <span>Tạm tính:</span>
                            <span>{{ number_format($cart->items->sum(fn($item) => $item->productVariant->product->price * $item->quantity), 0, ',', '.') }}đ</span>
                        </div>
                        <div class="summary-row">
                            <span>Phí vận chuyển:</span>
                            <span>30,000đ</span>
                        </div>
                        <div class="summary-row total">
                            <span>Tổng cộng:</span>
                            <span>{{ number_format($cart->items->sum(fn($item) => $item->productVariant->product->price * $item->quantity) + 30000, 0, ',', '.') }}đ</span>
                        </div>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="checkout-btn">Tiến hành thanh toán</a>
                </div>
            @else
                <p>Giỏ hàng của bạn đang trống.</p>
                <div class="cart-actions">
                    <a href="/products" class="continue-shopping">Tiếp tục mua sắm</a>
                </div>
            @endif
        </div>
    </div>
@endsection