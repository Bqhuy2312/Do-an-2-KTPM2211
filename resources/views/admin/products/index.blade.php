@extends('admin.layout')

@section('content')
    <h1>Quản lý sản phẩm</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('products.create') }}">
        <button class="btn-detail-order">Thêm sản phẩm</button>
    </a>

    <div class="filter-bar">
        <form action="{{ route('products.index') }}" method="GET" class="filter-form">
            <select name="category_id" onchange="this.form.submit()" class="filter-select">
                <option value="">Tất cả danh mục</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>Danh mục</th>
                <th>Giá</th>
                <th>Hình ảnh</th>
                <th>Nổi bật</th>
                <th>Bán chạy</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ number_format($product->price) }} VNĐ</td>
                    <td>
                        @if($product->mainImage)
                            <img src="{{ asset($product->mainImage->image_path) }}" alt="Ảnh sản phẩm" width="50">
                        @else
                            <span>Không có ảnh</span>
                        @endif
                    </td>
                    <td>{{ $product->featured ? 'Có' : 'Không' }}</td>
                    <td>{{ $product->best_seller ? 'Có' : 'Không' }}</td>
                    <td>
                        <a href="{{ route('products.edit', $product->id) }}" class="action-btn">
                            <button class="btn-edit">Sửa</button>
                        </a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline-block;" class="form-delete">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')" class="btn-delete">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection