@extends('client.layout')

@section('title', 'Đăng ký tài khoản')

@section('content')
<div class="account-page">
    <div class="auth-container">
        <h2>Đăng ký tài khoản</h2>
        
        <form class="auth-form" method="POST" action="{{ route('account.register') }}">
            @csrf
            
            <div class="form-group">
                <label for="name">Họ và tên <span class="required">*</span></label>
                <input type="text" id="name" name="name" required 
                       placeholder="Nguyễn Văn A">
                <small class="form-text">Vui lòng nhập họ tên đầy đủ</small>
            </div>
            
            <div class="form-group">
                <label for="email">Email <span class="required">*</span></label>
                <input type="email" id="email" name="email" required 
                       placeholder="example@email.com">
            </div>
            
            <div class="form-group">
                <label for="password">Mật khẩu <span class="required">*</span></label>
                <input type="password" id="password" name="password" required 
                       placeholder="Ít nhất 8 ký tự">
            </div>
            
            <div class="form-group">
                <label for="password_confirmation">Xác nhận mật khẩu <span class="required">*</span></label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <div class="form-group">
                <label for="phone">Số điện thoại <span class="required">*</span></label>
                <input type="tel" id="phone" name="phone" required 
                       placeholder="số điện thoại">
            </div>
            
            <div class="form-group">
                <label for="address">Địa chỉ</label>
                <textarea id="address" name="address" rows="3" 
                          placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành phố"></textarea>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-primary">Đăng ký</button>
            </div>
            
            <div class="auth-footer">
                Đã có tài khoản? <a href="{{ route('account.login') }}">Đăng nhập ngay</a>
            </div>
        </form>
    </div>
</div>
@endsection