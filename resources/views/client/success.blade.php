@extends('client.layout')

@section('content')
<div class="checkout-success">
    <h1>Đặt hàng thành công!</h1>
    <p>Cảm ơn bạn đã đặt hàng. Chúng tôi sẽ xử lý đơn hàng của bạn trong thời gian sớm nhất.</p>
    <a href="{{ route('home') }}" class="btn btn-primary">Quay lại trang chủ</a>
</div>
@endsection