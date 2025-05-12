@extends('admin.layout')

@section('content')
    <h1>Thêm danh mục</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div>
            <label>Tên danh mục:</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div>
            <label>Giới tính:</label>
            <select name="gender" required>
                <option value="unisex" {{ old('gender') == 'unisex' ? 'selected' : '' }}>Unisex</option>
                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Nam</option>
                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Nữ</option>
            </select>
        </div>

        <div>
            <label for="description">Mô tả:</label>
            <textarea name="description" id="description">{{ old('description') }}</textarea>
        </div>

        <button type="submit">Thêm</button>
    </form>
@endsection
