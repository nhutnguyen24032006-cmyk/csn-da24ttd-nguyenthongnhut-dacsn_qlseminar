@extends('layouts.app')
@section('title', 'Đăng nhập')
@section('content')
<div class="auth-wrapper">
  <div class="auth-card">
    <div class="panel">
      <div class="text-center mb-4">
        <div style="width:56px;height:56px;background:linear-gradient(135deg,var(--primary),#818cf8);border-radius:16px;display:inline-flex;align-items:center;justify-content:center;margin-bottom:.75rem;box-shadow:0 8px 24px rgba(99,102,241,.3)">
          <i class="bi bi-person-fill" style="font-size:1.5rem;color:#fff"></i>
        </div>
        <h3>Chào mừng trở lại</h3>
        <p class="subtitle">Đăng nhập để quản lý và đăng ký seminar</p>
      </div>
      <form method="post" action="{{ route('login') }}">@csrf
        <div class="mb-3">
          <label class="form-label">Email</label>
          <div class="input-group">
            <span class="input-group-text" style="background:var(--paper);border:1px solid var(--border);border-right:none;border-radius:var(--radius-sm) 0 0 var(--radius-sm);color:var(--text-muted)"><i class="bi bi-envelope"></i></span>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="name@example.com" required style="border-left:none;border-radius:0 var(--radius-sm) var(--radius-sm) 0">
          </div>
          @error('email')<div class="text-danger mt-1" style="font-size:.8rem">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Mật khẩu</label>
          <div class="input-group">
            <span class="input-group-text" style="background:var(--paper);border:1px solid var(--border);border-right:none;border-radius:var(--radius-sm) 0 0 var(--radius-sm);color:var(--text-muted)"><i class="bi bi-lock"></i></span>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required style="border-left:none;border-radius:0 var(--radius-sm) var(--radius-sm) 0">
          </div>
          @error('password')<div class="text-danger mt-1" style="font-size:.8rem">{{ $message }}</div>@enderror
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label" for="remember" style="font-size:.8rem;color:var(--text-secondary)">Ghi nhớ đăng nhập</label>
          </div>
        </div>
        <button class="btn-primary-custom w-100" style="padding:.7rem;font-size:.9rem">
          <i class="bi bi-box-arrow-in-right me-1"></i>Đăng nhập
        </button>
      </form>
      <div class="text-center mt-4" style="padding-top:1rem;border-top:1px solid var(--border)">
        <span style="font-size:.85rem;color:var(--text-secondary)">Chưa có tài khoản?</span>
        <a href="{{ route('register') }}" style="font-size:.85rem;font-weight:600;color:var(--primary);text-decoration:none"> Tạo tài khoản</a>
      </div>
    </div>
  </div>
</div>
@endsection
