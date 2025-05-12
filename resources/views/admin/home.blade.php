@extends('admin.layout')

@section('content')
    <h1>Trang chủ Admin</h1>
    
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-icon">📁</div>
            <h3>Tổng số danh mục</h3>
            <p class="stat-value">{{ $totalCategories }}</p>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">📦</div>
            <h3>Tổng số sản phẩm</h3>
            <p class="stat-value">{{ $totalProducts }}</p>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">🛒</div>
            <h3>Tổng số đơn hàng</h3>
            <p class="stat-value">{{ $totalOrders }}</p>
        </div>
    </div>
@endsection