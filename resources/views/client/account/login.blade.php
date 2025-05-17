@extends('client.layout')

@section('title', 'Đăng nhập')

@section('content')
<div class="account-page">
    <div class="auth-container">
        <h2>Đăng nhập</h2>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="auth-form" method="POST" action="{{ route('account.login') }}">
            @csrf
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-primary">Đăng nhập</button>
            </div>
            
            <div class="auth-footer">
                Chưa có tài khoản? <a href="{{ route('account.register') }}">Đăng ký ngay</a>
            </div>
        </form>
    </div>
</div>
@endsection