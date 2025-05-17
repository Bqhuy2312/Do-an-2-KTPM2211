@extends('admin.auth')

@section('content')
    <div class="login-box">
        <div class="login-header">
            <h1>Đăng nhập Admin</h1>
            <p>Vui lòng nhập thông tin đăng nhập</p>
        </div>
        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required placeholder="Nhập email">
            </div>
            
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" required placeholder="Nhập mật khẩu">
            </div>

            @if($errors->any())
                <div>
                    {{ $errors->first() }}
                </div>
            @endif
            
            <button type="submit" class="login-btn">Đăng nhập</button>
        </form>
    </div>
@endsection