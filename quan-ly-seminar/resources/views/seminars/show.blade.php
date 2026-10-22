@extends('layouts.app')
@section('title', $seminar->title)
@section('content')
<div class="container py-4">
  {{-- Breadcrumb --}}
  <nav class="mb-3">
    <a href="{{ route('home') }}" class="text-decoration-none" style="font-size:.85rem;color:var(--primary)">
      <i class="bi bi-arrow-left me-1"></i>Tất cả seminar
    </a>
  </nav>

  <div class="row g-4">
    {{-- ─── Main Content ─── --}}
    <div class="col-lg-8">
      <div class="panel">
        @if($seminar->category)
          <span class="category-tag" style="display:inline-flex;align-items:center;gap:.3rem;padding:.25rem .7rem;background:var(--primary-glow);color:var(--primary);font-size:.75rem;font-weight:600;border-radius:6px;margin-bottom:.75rem">
            <i class="bi bi-bookmark-fill"></i> {{ $seminar->category->name }}
          </span>
        @endif
        <h2 style="font-weight:800;letter-spacing:-.02em;line-height:1.25;margin-bottom:.5rem">{{ $seminar->title }}</h2>
        <div class="d-flex align-items-center gap-2 mb-4" style="color:var(--text-secondary);font-size:.9rem">
          <i class="bi bi-person-circle" style="font-size:1.1rem;color:var(--primary)"></i>
          <span>{{ $seminar->speaker }}</span>
        </div>

        <div style="border-top:1px solid var(--border);padding-top:1.25rem">
          <h6 style="font-weight:700;font-size:.8rem;text-transform:uppercase;letter-spacing:.05em;color:var(--text-muted);margin-bottom:.75rem">
            <i class="bi bi-file-text me-1"></i>Nội dung giới thiệu
          </h6>
          <div style="white-space:pre-line;max-width:70ch;color:var(--text-secondary);line-height:1.8">{{ $seminar->description }}</div>
        </div>
      </div>
    </div>

    {{-- ─── Sidebar ─── --}}
    <div class="col-lg-4">
      <div class="panel" style="position:sticky;top:5rem">
        <h6 style="font-weight:700;font-size:.8rem;text-transform:uppercase;letter-spacing:.05em;color:var(--text-muted);margin-bottom:1rem">
          <i class="bi bi-info-circle me-1"></i>Thông tin buổi seminar
        </h6>

        <div class="detail-info-row">
          <div class="detail-info-icon calendar"><i class="bi bi-calendar-event-fill"></i></div>
          <div>
            <div style="font-size:.75rem;color:var(--text-muted);font-weight:500">Thời gian</div>
            <div style="font-weight:600;font-size:.875rem">{{ $seminar->starts_at->format('d/m/Y') }}</div>
            <div style="color:var(--text-secondary);font-size:.8rem">{{ $seminar->starts_at->format('H:i') }} – {{ $seminar->ends_at->format('H:i') }}</div>
          </div>
        </div>

        <div class="detail-info-row">
          <div class="detail-info-icon location"><i class="bi bi-geo-alt-fill"></i></div>
          <div>
            <div style="font-size:.75rem;color:var(--text-muted);font-weight:500">Địa điểm</div>
            <div style="font-weight:600;font-size:.875rem">{{ $seminar->location }}</div>
          </div>
        </div>

        <div class="detail-info-row">
          <div class="detail-info-icon deadline"><i class="bi bi-hourglass-split"></i></div>
          <div>
            <div style="font-size:.75rem;color:var(--text-muted);font-weight:500">Hạn đăng ký</div>
            <div style="font-weight:600;font-size:.875rem">{{ $seminar->register_until->format('d/m/Y H:i') }}</div>
          </div>
        </div>

        <div class="detail-info-row" style="border-bottom:none !important">
          <div class="detail-info-icon people"><i class="bi bi-people-fill"></i></div>
          <div style="flex:1">
            <div style="font-size:.75rem;color:var(--text-muted);font-weight:500">Số chỗ</div>
            @php $pct = min(100, round(($seminar->capacity - $seminar->seats_left) / max(1,$seminar->capacity) * 100)); @endphp
            <div class="capacity-bar mt-1" style="height:6px">
              <div class="capacity-bar-fill {{ $pct >= 90 ? 'full' : ($pct >= 70 ? 'nearly-full' : '') }}" style="width:{{ $pct }}%"></div>
            </div>
            <div style="font-weight:600;font-size:.85rem">Còn {{ $seminar->seats_left }}/{{ $seminar->capacity }} chỗ</div>
          </div>
        </div>

        {{-- ─── Action Buttons ─── --}}
        <div style="margin-top:1rem;padding-top:1rem;border-top:1px solid var(--border)">
          @auth
            @if($joined)
              <div style="background:var(--success-soft);color:#065f46;padding:.65rem 1rem;border-radius:var(--radius-sm);font-size:.85rem;font-weight:600;margin-bottom:.75rem;display:flex;align-items:center;gap:.4rem">
                <i class="bi bi-check-circle-fill"></i> Bạn đã đăng ký buổi này
              </div>
              <form method="post" action="{{ route('seminars.cancel', $seminar) }}">
                @csrf @method('DELETE')
                <button class="btn btn-outline-danger w-100" style="border-radius:var(--radius-sm);font-weight:600;font-size:.85rem;padding:.6rem">
                  <i class="bi bi-x-lg me-1"></i>Hủy đăng ký
                </button>
              </form>
            @elseif($seminar->isOpen())
              <form method="post" action="{{ route('seminars.register', $seminar) }}">
                @csrf
                <button class="btn-primary-custom w-100" style="padding:.7rem;font-size:.9rem">
                  <i class="bi bi-check2-circle me-1"></i>Đăng ký tham dự
                </button>
              </form>
            @else
              <div style="background:var(--paper);color:var(--text-secondary);padding:.65rem 1rem;border-radius:var(--radius-sm);font-size:.85rem;font-weight:500;text-align:center">
                <i class="bi bi-lock-fill me-1"></i>Seminar không còn nhận đăng ký
              </div>
            @endif
          @else
            <a href="{{ route('login') }}" class="btn-primary-custom w-100 d-block text-center text-decoration-none" style="padding:.7rem;font-size:.9rem">
              <i class="bi bi-box-arrow-in-right me-1"></i>Đăng nhập để đăng ký
            </a>
          @endauth
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
