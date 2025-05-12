@extends('client.layout')

@section('content')
<div class="search-results">
    <h1>Kết quả tìm kiếm cho: "{{ $query }}"</h1>

    @if ($products->count() > 0)
        <div class="product-grid">
            @foreach ($products as $product)
                <div class="product-card">
                    <div class="product-image">
                        <a href="{{ route('client.product.detail', $product->id) }}">
                            <img src="{{ asset($product->mainImage->image_path ?? 'images/default-product.jpg') }}" alt="{{ $product->name }}">
                        </a>
                    </div>
                    <div class="product-info">
                        <h2>
                            <a href="{{ route('client.product.detail', $product->id) }}">{{ $product->name }}</a>
                        </h2>
                        <p class="product-price">{{ number_format($product->price, 0, ',', '.') }}đ</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pagination">
            {{ $products->links() }}
        </div>
    @else
        <p class="no-results">Không tìm thấy sản phẩm nào phù hợp.</p>
    @endif
</div>
@endsection