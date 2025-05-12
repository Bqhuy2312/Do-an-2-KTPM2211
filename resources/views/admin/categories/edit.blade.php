@extends('admin.layout')

@section('content')
    <h1>Sửa danh mục</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>Tên danh mục:</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" required>
        </div>

        <div>
            <label>Giới tính:</label>
            <select name="gender" required>
                <option value="unisex" {{ old('gender', $category->gender) == 'unisex' ? 'selected' : '' }}>Unisex</option>
                <option value="male" {{ old('gender', $category->gender) == 'male' ? 'selected' : '' }}>Nam</option>
                <option value="female" {{ old('gender', $category->gender) == 'female' ? 'selected' : '' }}>Nữ</option>
            </select>
        </div>

        <div>
            <label for="description">Mô tả:</label>
            <textarea name="description" id="description">{{ old('description', $category->description) }}</textarea>
        </div>

        <button type="submit">Cập nhật</button>
    </form>
@endsection
