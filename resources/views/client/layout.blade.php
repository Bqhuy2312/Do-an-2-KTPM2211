<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Store - Thời trang nam nữ</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="logo">
                <a href="{{ url('/') }}">FashionStore</a>
            </div>
            
            <div class="search-box">
                <form action="{{ route('products.search') }}" method="GET" class="search-form">
                    <input type="text" name="q" placeholder="Tìm kiếm sản phẩm..." value="{{ request('q') }}">
                    <button type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            
            <div class="user-actions">
                @auth
                    <a href="{{ route('account.profile') }}" class="user-icon">
                        <i class="fas fa-user"></i>
                    </a>
                @else
                    <a href="{{ route('account.login') }}" class="user-icon">
                        <i class="fas fa-user"></i>
                    </a>
                @endauth
                @auth
                    <a href="{{ url('/cart') }}" class="cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                @else
                    <a href="{{ route('account.login') }}" class="user-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                @endauth
            </div>
        </div>
    </header>
    
    <nav class="main-nav">
        <div class="container">
            <ul>
                <li><a href="{{ url('/') }}">Trang chủ</a></li>
                <li><a href="{{ route('client.products.index') }}">Sản phẩm</a></li>
            </ul>
        </div>
    </nav>
    
    <main class="main-content">
        @yield('content')
    </main>
    
    <footer class="footer">
        <div class="container">
            <div class="footer-section">
                <h3>Về chúng tôi</h3>
                <p>FashionStore - Thương hiệu thời trang uy tín, chất lượng</p>
            </div>
            <div class="footer-section">
                <h3>Liên hệ</h3>
                <p><i class="fas fa-phone"></i> 0123.456.789</p>
                <p><i class="fas fa-envelope"></i> contact@fashionstore.com</p>
            </div>
            <div class="footer-section">
                <h3>Đăng ký nhận tin</h3>
                <form class="newsletter-form">
                    <input type="email" placeholder="Nhập email của bạn">
                    <button type="submit">Đăng ký</button>
                </form>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2025 FashionStore. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>