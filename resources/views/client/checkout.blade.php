@extends('client.layout')

@section('content')
<div class="checkout-page">
    <h1 class="page-title">Thanh Toán</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="checkout-container">
        <form method="POST" action="{{ route('checkout.process') }}">
            @csrf
            <section class="shipping-info">
                <h2 class="section-title">Thông tin giao hàng</h2>
                <div class="form-group">
                    <label>Họ và tên</label>
                    <input type="text" name="name" placeholder="Nhập họ và tên" value="{{ Auth::user()->name ?? '' }}" required>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="tel" name="phone" placeholder="Nhập số điện thoại" value="{{ Auth::user()->phone ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="Nhập email" value="{{ Auth::user()->email ?? '' }}" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Địa chỉ giao hàng</label>
                    <textarea name="shipping_address" placeholder="Nhập địa chỉ giao hàng" required>{{ Auth::user()->address ?? '' }}</textarea>
                </div>
                
                <div class="form-group">
                    <label>Ghi chú (tuỳ chọn)</label>
                    <textarea name="note" placeholder="Ghi chú về đơn hàng"></textarea>
                </div>
            </section>

            <section class="order-review">
                <h2 class="section-title">Đơn hàng của bạn</h2>
                <div class="order-items">
                    @foreach ($cart->items as $item)
                        <div class="order-item">
                            <div class="item-info">
                                <img src="{{ asset($item->productVariant->product->mainImage->image_path ?? 'images/default-product.jpg') }}" alt="{{ $item->productVariant->product->name }}">
                                <div>
                                    <h3>{{ $item->productVariant->product->name }}</h3>
                                    <p>Màu: {{ $item->productVariant->color }} / Size: {{ $item->productVariant->size }}</p>
                                </div>
                            </div>
                            <div class="item-price">{{ number_format($item->productVariant->product->price, 0, ',', '.') }}đ × {{ $item->quantity }}</div>
                            <div class="item-total">{{ number_format($item->productVariant->product->price * $item->quantity, 0, ',', '.') }}đ</div>
                        </div>
                    @endforeach
                </div>
                
                <div class="order-summary">
                    <div class="summary-row">
                        <span>Tạm tính:</span>
                        <span>{{ number_format($subtotal, 0, ',', '.') }}đ</span>
                    </div>
                    <div class="summary-row">
                        <span>Phí vận chuyển:</span>
                        <span>30,000đ</span>
                    </div>
                    <div class="summary-row total">
                        <span>Tổng cộng:</span>
                        <span>{{ number_format($subtotal + 30000, 0, ',', '.') }}đ</span>
                    </div>
                </div>
                
                <div class="payment-methods">
                    <h3>Phương thức thanh toán</h3>
                    <div class="payment-option">
                        <input type="radio" id="cod" name="payment_method" value="cod" checked>
                        <label for="cod">Thanh toán khi nhận hàng (COD)</label>
                    </div>
                </div>
                
                <button type="submit" class="place-order-btn">Đặt hàng</button>
            </section>
        </form>
    </div>
</div>
@endsection