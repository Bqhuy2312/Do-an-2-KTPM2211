@extends('admin.layout')

@section('content')
    <h1>Thêm sản phẩm</h1>
    
    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div>
            <label for="name">Tên sản phẩm:</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required>
        </div>

        <div>
            <label for="description">Mô tả:</label>
            <textarea name="description" id="description">{{ old('description') }}</textarea>
        </div>

        <div>
            <label for="price">Giá:</label>
            <input type="number" name="price" id="price" value="{{ old('price') }}" required>
        </div>

        <div>
            <label for="category_id">Danh mục:</label>
            <select name="category_id" id="category_id" required>
                <option value="">Chọn danh mục</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="image">Hình ảnh:</label>
            <input type="file" name="image" id="image">
        </div>

        <div id="variants-container">
            <h3>Biến thể sản phẩm</h3>
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
        </div>
        <button type="button" id="add-variant">Thêm biến thể</button>

        <button type="submit">Thêm</button>
    </form>

    <script>
        document.getElementById('add-variant').addEventListener('click', function() {
            const container = document.getElementById('variants-container');
            const newVariant = container.querySelector('.variant-item').cloneNode(true);
            
            newVariant.querySelectorAll('input').forEach(input => {
                input.value = '';
            });
            
            container.appendChild(newVariant);
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-variant')) {
                if (document.querySelectorAll('.variant-item').length > 1) {
                    e.target.closest('.variant-item').remove();
                } else {
                    alert('Phải có ít nhất một biến thể sản phẩm');
                }
            }
        });
    </script>
@endsection