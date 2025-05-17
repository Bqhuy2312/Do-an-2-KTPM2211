@extends('client.layout')

@section('content')
    <div class="product-listing">
        <div class="filters">
            <h3>Bộ lọc</h3>
            <form method="GET" action="{{ route('client.products.index') }}">
                <div class="filter-section">
                    <h4>Danh mục</h4>
                    <select name="category">
                        <option value="">Tất cả</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-section">
                    <h4>Sắp xếp</h4>
                    <select name="sort">
                        <option value="">Mặc định</option>
                        <option value="price_asc">Giá thấp đến cao</option>
                        <option value="price_desc">Giá cao đến thấp</option>
                    </select>
                </div>
                <button type="submit">Lọc</button>
            </form>
        </div>
        
        <div class="product-results">
            <div class="product-grid">
                @foreach ($products as $product)
                    <div class="product-card">
                        <a href="{{ route('client.product.detail', ['id' => $product->id]) }}" class="product-card">
                            <div class="product-image-container">
                                <img src="{{ asset($product->mainImage->image_path) }}" alt="{{ $product->name }}" class="product-image">
                            </div>
                            <div class="product-info">
                                <h3 class="product-name">{{ $product->name }}</h3>
                                <div class="product-price">{{ number_format($product->price) }}đ</div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            
            <div class="pagination">
                {{ $products->links('pagination::simple-bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection