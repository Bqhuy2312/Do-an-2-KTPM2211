@extends('client.layout')

@section('title', 'Thông tin tài khoản')

@section('content')
<div class="account-page">
    <div class="account-container">
        <div class="account-sidebar">
            <div class="user-info">
                <div class="avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="user-name">{{ $user->name }}</div>
            </div>
            
            <nav class="account-menu">
                <ul>
                    <li class="active">
                        <a href="{{ route('account.profile') }}">
                            <i class="fas fa-user"></i> Thông tin cá nhân
                        </a>
                    </li>
                    <li>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Đăng xuất
                        </a>
                        <form id="logout-form" method="POST" action="{{ route('account.logout') }}" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
        
        <div class="account-content">
            <h2>Thông tin cá nhân</h2>
            
            <form class="profile-form" method="POST" action="#">
                @csrf
                @method('PUT')
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="fullname">Họ và tên</label>
                        <input type="text" id="fullname" name="fullname" value="{{ $user->name }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Số điện thoại</label>
                        <input type="tel" id="phone" name="phone" value="{{ $user->phone }}" placeholder="{{ $user->phone }}">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="address">Địa chỉ</label>
                    <textarea id="address" name="address">{{ $user->address }}</textarea>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn-primary">Cập nhật thông tin</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection