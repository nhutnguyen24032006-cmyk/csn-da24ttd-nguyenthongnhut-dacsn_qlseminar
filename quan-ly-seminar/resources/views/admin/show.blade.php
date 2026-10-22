@extends('layouts.app')
@section('title', 'Người đăng ký: ' . $seminar->title)
@section('content')
<div class="container py-4">
  {{-- Breadcrumb --}}
  <nav class="mb-3">
    <a href="{{ route('admin.seminars.index') }}" class="text-decoration-none" style="font-size:.85rem;color:var(--text-secondary)">
      <i class="bi bi-arrow-left me-1"></i> Quay lại danh sách quản lý seminar
    </a>
  </nav>

  {{-- Seminar Header Card --}}
  <div class="panel mb-4" style="background:linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-3">
      <div style="flex:1;min-width:280px">
        <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
          @if($seminar->category)
            <span class="seminar-category" style="background:rgba(99,102,241,.1);color:var(--primary);font-size:.72rem;font-weight:700;padding:.2rem .6rem;border-radius:6px">
              {{ $seminar->category->name }}
            </span>
          @endif
          @if($seminar->status === 'cancelled')
            <span class="badge-cancelled"><i class="bi bi-x-circle me-1"></i>Đã hủy</span>
          @elseif($seminar->isFull())
            <span class="badge" style="background:var(--accent-soft);color:var(--accent);font-size:.72rem;font-weight:700;padding:.25rem .6rem;border-radius:6px">
              <i class="bi bi-exclamation-circle me-1"></i>Đã hết chỗ
            </span>
          @else
            <span class="badge-open"><i class="bi bi-check-circle me-1"></i>Đang mở</span>
          @endif
        </div>
        <h3 style="font-weight:800;letter-spacing:-.02em;margin-bottom:.5rem;line-height:1.3">{{ $seminar->title }}</h3>
        <div class="d-flex flex-wrap gap-3" style="font-size:.85rem;color:var(--text-secondary)">
          <span><i class="bi bi-person me-1 text-primary"></i><strong>Diễn giả:</strong> {{ $seminar->speaker }}</span>
          <span><i class="bi bi-geo-alt me-1 text-danger"></i><strong>Địa điểm:</strong> {{ $seminar->location }}</span>
          <span><i class="bi bi-calendar-event me-1 text-success"></i><strong>Thời gian:</strong> {{ $seminar->starts_at->format('d/m/Y H:i') }}</span>
        </div>
      </div>
      <div class="d-flex gap-2">
        <a href="{{ route('seminars.show', $seminar) }}" target="_blank" class="btn btn-sm btn-outline-secondary" style="border-radius:var(--radius-sm);font-weight:600;font-size:.8rem;padding:.4rem .8rem">
          <i class="bi bi-box-arrow-up-right me-1"></i>Xem trang web
        </a>
        <a href="{{ route('admin.seminars.edit', $seminar) }}" class="btn-primary-custom" style="padding:.4rem .9rem;font-size:.8rem">
          <i class="bi bi-pencil-square me-1"></i>Sửa seminar
        </a>
      </div>
    </div>

    {{-- Capacity Metrics --}}
    @php
      $registeredCount = $regs->count();
      $capacity = $seminar->capacity;
      $available = max(0, $capacity - $registeredCount);
      $percentage = $capacity > 0 ? min(100, round(($registeredCount / $capacity) * 100)) : 0;
    @endphp
    <div class="pt-3" style="border-top:1px solid var(--border)">
      <div class="row g-3 align-items-center">
        <div class="col-md-7">
          <div class="d-flex justify-content-between align-items-center mb-1">
            <span style="font-size:.8rem;font-weight:600;color:var(--text)">
              Tiến độ đăng ký chỗ ngồi: <strong>{{ $registeredCount }}</strong> / {{ $capacity }} chỗ
            </span>
            <span style="font-size:.8rem;font-weight:700;color:{{ $percentage >= 100 ? 'var(--danger)' : ($percentage >= 80 ? 'var(--accent)' : 'var(--primary)') }}">
              {{ $percentage }}%
            </span>
          </div>
          <div class="capacity-bar" style="height:8px">
            <div class="capacity-bar-fill {{ $percentage >= 100 ? 'full' : ($percentage >= 80 ? 'nearly-full' : '') }}" style="width: {{ $percentage }}%"></div>
          </div>
        </div>
        <div class="col-md-5 d-flex justify-content-md-end gap-3">
          <div class="text-center px-3 py-1" style="background:var(--paper);border-radius:var(--radius-sm);border:1px solid var(--border)">
            <div style="font-size:1.1rem;font-weight:800;color:var(--primary)">{{ $registeredCount }}</div>
            <div style="font-size:.7rem;color:var(--text-muted);font-weight:600">ĐÃ ĐĂNG KÝ</div>
          </div>
          <div class="text-center px-3 py-1" style="background:var(--paper);border-radius:var(--radius-sm);border:1px solid var(--border)">
            <div style="font-size:1.1rem;font-weight:800;color:{{ $available == 0 ? 'var(--danger)' : 'var(--success)' }}">{{ $available }}</div>
            <div style="font-size:.7rem;color:var(--text-muted);font-weight:600">CÒN TRỐNG</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Attendees List Panel --}}
  <div class="panel p-0" style="overflow:hidden">
    {{-- Header inside table --}}
    <div class="d-flex justify-content-between align-items-center p-3 flex-wrap gap-2" style="background:var(--paper);border-bottom:1px solid var(--border)">
      <div class="d-flex align-items-center gap-2">
        <i class="bi bi-people-fill text-primary" style="font-size:1.1rem"></i>
        <h5 style="font-weight:700;font-size:1rem;margin:0">Danh sách người tham dự</h5>
        <span class="badge" style="background:var(--primary);color:#fff;border-radius:20px;font-size:.72rem;padding:.25rem .6rem">
          {{ $registeredCount }} người
        </span>
      </div>
      <div>
        <button class="btn btn-sm btn-outline-secondary" onclick="window.print()" style="font-size:.8rem;border-radius:var(--radius-sm);background:#fff">
          <i class="bi bi-printer me-1"></i>In danh sách
        </button>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-custom mb-0">
        <thead>
          <tr>
            <th style="width:50px" class="text-center">STT</th>
            <th>Họ và tên</th>
            <th>Mã số SV / Cán bộ</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th class="text-end">Thời gian đăng ký</th>
          </tr>
        </thead>
        <tbody>
        @forelse($regs as $index => $r)
          <tr>
            <td class="text-center text-muted fw-semibold" style="font-size:.8rem">{{ $index + 1 }}</td>
            <td>
              <div class="d-flex align-items-center gap-2">
                <div style="width:34px;height:34px;background:linear-gradient(135deg,var(--primary),#818cf8);color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.75rem;flex-shrink:0">
                  {{ strtoupper(mb_substr($r->user->name, 0, 1)) }}
                </div>
                <div>
                  <div style="font-weight:600;color:var(--text)">{{ $r->user->name }}</div>
                  @if($r->user->isAdmin())
                    <span class="badge" style="background:rgba(99,102,241,.12);color:var(--primary);font-size:.65rem;padding:.15rem .45rem">Quản trị viên</span>
                  @endif
                </div>
              </div>
            </td>
            <td>
              @if($r->user->student_code)
                <span class="badge" style="background:var(--paper);color:var(--ink-light);border:1px solid var(--border);font-family:monospace;font-size:.78rem;padding:.3rem .55rem">
                  {{ $r->user->student_code }}
                </span>
              @else
                <span style="color:var(--text-muted);font-size:.8rem">—</span>
              @endif
            </td>
            <td>
              <a href="mailto:{{ $r->user->email }}" style="color:var(--text-secondary);text-decoration:none;font-size:.85rem">
                <i class="bi bi-envelope me-1 text-muted"></i>{{ $r->user->email }}
              </a>
            </td>
            <td>
              @if($r->user->phone)
                <a href="tel:{{ $r->user->phone }}" style="color:var(--text-secondary);text-decoration:none;font-size:.85rem">
                  <i class="bi bi-telephone me-1 text-muted"></i>{{ $r->user->phone }}
                </a>
              @else
                <span style="color:var(--text-muted);font-size:.8rem">—</span>
              @endif
            </td>
            <td class="text-end">
              <span style="font-size:.8rem;color:var(--text-secondary)">
                <i class="bi bi-clock me-1 text-muted"></i>{{ $r->created_at->format('d/m/Y H:i') }}
              </span>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="text-center py-5">
              <div style="width:64px;height:64px;background:var(--paper);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;color:var(--text-muted);font-size:1.8rem">
                <i class="bi bi-inbox"></i>
              </div>
              <h6 style="font-weight:700;color:var(--text);margin-bottom:.25rem">Chưa có ai đăng ký</h6>
              <p style="color:var(--text-muted);font-size:.85rem;margin:0">
                Khi sinh viên hoặc người tham dự đăng ký buổi seminar này, danh sách sẽ hiển thị tại đây.
              </p>
            </td>
          </tr>
        @endforelse
        </tbody>
      </table>
    </div>

    @if($regs->isNotEmpty())
      <div class="p-3 d-flex justify-content-between align-items-center" style="background:var(--paper);border-top:1px solid var(--border);font-size:.8rem;color:var(--text-secondary)">
        <span>Tổng cộng: <strong>{{ $registeredCount }}</strong> người đăng ký</span>
        <span>Cập nhật theo thời gian thực</span>
      </div>
    @endif
  </div>
</div>
@endsection
