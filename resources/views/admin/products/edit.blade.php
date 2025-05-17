@extends('admin.layout')

@section('content')
    <h1>Sửa sản phẩm</h1>
    
    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div>
            <label for="name">Tên sản phẩm:</label>
            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required>
        </div>

        <div>
            <label for="description">Mô tả:</label>
            <textarea name="description" id="description">{{ old('description', $product->description) }}</textarea>
        </div>

        <div>
            <label for="price">Giá:</label>
            <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" required>
        </div>

        <div>
            <label for="category_id">Danh mục:</label>
            <select name="category_id" id="category_id" required>
                <option value="">Chọn danh mục</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="image">Hình ảnh mới:</label>
            <input type="file" name="image" id="image">
            
            @if($product->mainImage)
                <div>
                    <img src="{{ asset($product->mainImage->image_path) }}" alt="Ảnh sản phẩm" width="100">
                    <p>Ảnh hiện tại</p>
                </div>
            @endif
        </div>

        <div id="variants-container">
            <h3>Biến thể sản phẩm</h3>
        
            @php
            $colors = old('colors', $product->variants->pluck('color')->toArray());
            $sizes = old('sizes', $product->variants->pluck('size')->toArray());
            $quantities = old('quantities', $product->variants->pluck('quantity')->toArray());
        
            if (empty($colors)) {
                $colors = [''];
                $sizes = [''];
                $quantities = [''];
            }
            @endphp
            @foreach($product->variants as $variant)
                <div class="variant-item">
                    <input type="hidden" name="variant_ids[]" value="{{ $variant->id }}">
                    <div>
                        <label>Màu sắc:</label>
                        <input type="text" name="colors[]" value="{{ old('colors.' . $loop->index, $variant->color) }}" required>
                    </div>
                    <div>
                        <label>Kích thước:</label>
                        <input type="text" name="sizes[]" value="{{ old('sizes.' . $loop->index, $variant->size) }}" required>
                    </div>
                    <div>
                        <label>Số lượng:</label>
                        <input type="number" name="quantities[]" min="1" value="{{ old('quantities.' . $loop->index, $variant->quantity) }}" required>
                    </div>
                    <button type="button" class="remove-variant">Xóa</button>
                </div>
            @endforeach
        </div>
        <button type="button" id="add-variant">Thêm biến thể</button>

        <button type="submit">Cập nhật</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const variantsContainer = document.getElementById('variants-container');
            const addVariantBtn = document.getElementById('add-variant');
    
            addVariantBtn.addEventListener('click', function () {
                const variantHTML = `
                    <div class="variant-item">
                        <div>
                            <label>Màu sắc:</label>
                            <input type="text" name="colors[]" required>
                        </div>
                        <div>
                            <label>Kích thước:</label>
                            <input type="text" name="sizes[]" required>
                        </div>
                        <div>
                            <label>Số lượng:</label>
                            <input type="number" name="quantities[]" min="0" required>
                        </div>
                        <button type="button" class="remove-variant">Xóa</button>
                    </div>
                `;
                variantsContainer.insertAdjacentHTML('beforeend', variantHTML);
            });
    
            document.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-variant')) {
                    const variantItems = document.querySelectorAll('.variant-item');
                    if (variantItems.length > 1) {
                        e.target.closest('.variant-item').remove();
                    } else {
                        alert('Phải có ít nhất một biến thể sản phẩm');
                    }
                }
            });
        });
    </script>
@endsection