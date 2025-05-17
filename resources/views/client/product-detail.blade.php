@extends('client.layout')

@section('content')
    <div class="product-detail">
        <div class="breadcrumb">
            <a href="/">Trang chủ</a> &raquo; 
            <a href="/products">Sản phẩm</a> &raquo; 
            <span>{{ $product->name }}</span>
        </div>
        
        <div class="detail-container">
            <div class="product-gallery">
                <div class="main-image">
                    <img src="{{ asset($product->mainImage->image_path ?? 'images/default-product.jpg') }}" alt="{{ $product->name }}">
                </div>
                <div class="thumbnail-list">
                    @foreach ($product->images as $image)
                        <img src="{{ asset($image->image_path) }}" alt="Thumbnail">
                    @endforeach
                </div>
            </div>
            
            <div class="product-info">
                <h1 class="product-title">{{ $product->name }}</h1>
                <div class="product-meta">
                    <span class="availability">{{ $product->variants->sum('quantity') > 0 ? 'Còn hàng' : 'Hết hàng' }}</span>
                </div>
                
                <div class="product-price">
                    <span class="current-price">{{ number_format($product->price) }}đ</span>
                </div>
                
                <div class="product-description">
                    <p>{{ $product->description }}</p>
                </div>
                
                <div class="product-actions">
                    <form method="POST" action="{{ route('cart.add') }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                
                        <div class="variant-option">
                            <label for="color">Chọn màu sắc:</label>
                            <select name="color" id="color" required>
                                <option value="" disabled selected>Chọn màu</option>
                                @foreach ($product->variants->unique('color') as $variant)
                                    <option value="{{ $variant->color }}">{{ $variant->color }}</option>
                                @endforeach
                            </select>
                        </div>
                
                        <div class="variant-option">
                            <label for="size">Chọn kích thước:</label>
                            <select name="size" id="size" required>
                                <option value="" disabled selected>Chọn kích thước</option>
                                @foreach ($product->variants->unique('size') as $variant)
                                    <option value="{{ $variant->size }}">{{ $variant->size }}</option>
                                @endforeach
                            </select>
                        </div>
                
                        <div class="variant-option">
                            <label for="quantity">Số lượng:</label>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" required>
                        </div>
                        @auth
                            <button type="submit" class="add-to-cart">Thêm vào giỏ hàng</button>
                        @else
                            <a href="{{ route('account.login') }}" class="add-to-cart">Đăng nhập để thêm vào giỏ hàng</a>
                        @endauth
                    </form>
                </div>
            </div>
        </div>
        
        <section class="related-products">
            <h2 class="section-title">Sản phẩm liên quan</h2>
            <div class="product-grid">
                @foreach ($relatedProducts as $related)
                    <a href="{{ route('client.product.detail', $related->id) }}" class="product-card">
                        <div class="product-image-container">
                            <img src="{{ asset($related->mainImage->image_path ?? 'images/default-product.jpg') }}" alt="{{ $related->name }}" class="product-image">
                        </div>
                        <div class="product-info">
                            <h3 class="product-name">{{ $related->name }}</h3>
                            <div class="product-price">{{ number_format($related->price) }}đ</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    </div>
@endsection