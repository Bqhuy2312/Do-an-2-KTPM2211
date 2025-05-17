<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Quản lý</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<div class="admin-container">
    <div class="sidebar">
        <h2>Quản lý Admin</h2>
        <ul>
            <li><a href="{{ url('admin/home') }}">Trang chủ</a></li>
            <li><a href="{{ url('admin/categories') }}">Quản lý danh mục</a></li>
            <li><a href="{{ url('admin/products') }}">Quản lý sản phẩm</a></li>
            <li><a href="{{ url('admin/orders') }}">Quản lý đơn hàng</a></li>
            <li><a href="{{ url('admin/reports') }}">Thống kê</a></li>
            <li>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit"><i class="fas fa-sign-out-alt"></i>Đăng xuất</button>
            </form>
        </li>
        </ul>
    </div>

    <div class="content">
        @yield('content')
    </div>
</div>

</body>
</html>
