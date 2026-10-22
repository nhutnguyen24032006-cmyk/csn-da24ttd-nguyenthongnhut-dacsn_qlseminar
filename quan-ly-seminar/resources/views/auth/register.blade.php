@extends('layouts.app')
@section('title', 'Tạo tài khoản')
@section('content')
<div class="auth-wrapper">
  <div class="auth-card" style="max-width:500px">
    <div class="panel">
      <div class="text-center mb-4">
        <div style="width:56px;height:56px;background:linear-gradient(135deg,var(--primary),#818cf8);border-radius:16px;display:inline-flex;align-items:center;justify-content:center;margin-bottom:.75rem;box-shadow:0 8px 24px rgba(99,102,241,.3)">
          <i class="bi bi-person-plus-fill" style="font-size:1.5rem;color:#fff"></i>
        </div>
        <h3>Tạo tài khoản mới</h3>
        <p class="subtitle">Đăng ký để tham gia các buổi seminar học thuật</p>
      </div>
      <form method="post" action="{{ route('register') }}">@csrf
        @php
          $fields = [
            ['name','Họ và tên','text','bi-person','Nguyễn Văn A'],
            ['email','Email','email','bi-envelope','name@example.com'],
            ['student_code','Mã số sinh viên / giảng viên','text','bi-card-heading','(Không bắt buộc)'],
            ['phone','Số điện thoại','text','bi-telephone','(Không bắt buộc)'],
            ['password','Mật khẩu (ít nhất 6 ký tự)','password','bi-lock','••••••••'],
            ['password_confirmation','Nhập lại mật khẩu','password','bi-lock-fill','••••••••'],
          ];
        @endphp
        @foreach($fields as [$n,$l,$t,$icon,$ph])
        <div class="mb-3">
          <label class="form-label">{{ $l }}</label>
          <div class="input-group">
            <span class="input-group-text" style="background:var(--paper);border:1px solid var(--border);border-right:none;border-radius:var(--radius-sm) 0 0 var(--radius-sm);color:var(--text-muted)"><i class="bi {{ $icon }}"></i></span>
            <input type="{{ $t }}" name="{{ $n }}" value="{{ $t === 'password' ? '' : old($n) }}" placeholder="{{ $ph }}" class="form-control @error($n) is-invalid @enderror" style="border-left:none;border-radius:0 var(--radius-sm) var(--radius-sm) 0">
          </div>
          @error($n)<div class="text-danger mt-1" style="font-size:.8rem">{{ $message }}</div>@enderror
        </div>
        @endforeach
        <button class="btn-primary-custom w-100 mt-1" style="padding:.7rem;font-size:.9rem">
          <i class="bi bi-check-circle me-1"></i>Tạo tài khoản
        </button>
      </form>
      <div class="text-center mt-4" style="padding-top:1rem;border-top:1px solid var(--border)">
        <span style="font-size:.85rem;color:var(--text-secondary)">Đã có tài khoản?</span>
        <a href="{{ route('login') }}" style="font-size:.85rem;font-weight:600;color:var(--primary);text-decoration:none"> Đăng nhập</a>
      </div>
    </div>
  </div>
</div>
@endsection
