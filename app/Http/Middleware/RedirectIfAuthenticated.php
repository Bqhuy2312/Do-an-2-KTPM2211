public function handle(Request $request, Closure $next, ...$guards)
{
    $guards = empty($guards) ? [null] : $guards;

    foreach ($guards as $guard) {
        if (Auth::guard($guard)->check()) {
            // Nếu đã đăng nhập bằng guard web (dùng chung cho cả user và admin)
            if ($guard === 'web') {
                // Kiểm tra role để redirect
                if (Auth::user()->role === 'admin') {
                    return redirect()->route('admin.home');
                }
                return redirect('/');
            }
            return redirect('/');
        }
    }

    return $next($request);
}