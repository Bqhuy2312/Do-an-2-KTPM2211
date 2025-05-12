@extends('client.layout')

@section('content')

    <section class="banner-slider">
        <div class="banner">
            <img src="{{ asset('images/banner1.jpg') }}" alt="Banner 1">
        </div>

    </section>
    

    <section class="featured-products">
        <h2 class="section-title">Sản phẩm nổi bật</h2>
        <div class="product-grid">
            @foreach ($featuredProducts as $product)
                <a href="{{ route('client.product.detail', ['id' => $product->id]) }}" class="product-card">
                    @if ($product->mainImage)
                        <img src="{{ asset($product->mainImage->image_path) }}" alt="{{ $product->name }}">
                    @else
                        <img src="{{ asset('images/no-image.png') }}" alt="Không có ảnh">
                    @endif
                    <div class="product-info">
                        <h3 class="product-name">{{ $product->name }}</h3>
                        <div class="product-price">
                            <span class="current-price">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>


    <section class="sale-products">
        <h2 class="section-title">Sản phẩm bán chạy</h2>
        <div class="product-grid">
            @foreach ($bestSellerProducts as $product)
                <a href="{{ route('client.product.detail', ['id' => $product->id]) }}" class="product-card">
                    @if ($product->mainImage)
                        <img src="{{ asset($product->mainImage->image_path) }}" alt="{{ $product->name }}">
                    @else
                        <img src="{{ asset('images/no-image.png') }}" alt="Không có ảnh">
                    @endif
                    <div class="product-info">
                        <h3 class="product-name">{{ $product->name }}</h3>
                        <div class="product-price">
                            <span class="current-price">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
@endsection