@extends('layouts.app')
@section('title', 'Quản lý seminar')
@section('content')
<div class="container py-4">
  {{-- Header --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h3 style="font-weight:800;letter-spacing:-.02em;margin-bottom:.15rem">Quản lý Seminar</h3>
      <p style="color:var(--text-secondary);font-size:.85rem;margin:0">Tạo, sửa, xóa và theo dõi lượt đăng ký</p>
    </div>
    <a class="btn-primary-custom" href="{{ route('admin.seminars.create') }}">
      <i class="bi bi-plus-lg me-1"></i>Đăng seminar mới
    </a>
  </div>

  {{-- Stats --}}
  <div class="row g-3 mb-4">
    @php
      $total = $seminars->total();
      $openCount = $seminars->where('status', 'open')->count();
    @endphp
    <div class="col-6 col-md-3">
      <div class="panel text-center py-3">
        <div style="font-size:1.5rem;font-weight:800;color:var(--primary)">{{ $total }}</div>
        <div style="font-size:.75rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;letter-spacing:.05em">Tổng seminar</div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="panel text-center py-3">
        <div style="font-size:1.5rem;font-weight:800;color:var(--success)">{{ $openCount }}</div>
        <div style="font-size:.75rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;letter-spacing:.05em">Đang mở</div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="panel text-center py-3">
        <div style="font-size:1.5rem;font-weight:800;color:var(--accent)">{{ $seminars->sum('registrations_count') }}</div>
        <div style="font-size:.75rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;letter-spacing:.05em">Lượt đăng ký</div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="panel text-center py-3">
        <div style="font-size:1.5rem;font-weight:800;color:var(--danger)">{{ $seminars->where('status', 'cancelled')->count() }}</div>
        <div style="font-size:.75rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;letter-spacing:.05em">Đã hủy</div>
      </div>
    </div>
  </div>

  {{-- Table --}}
  <div class="panel p-0" style="overflow:hidden">
    <div class="table-responsive">
      <table class="table table-custom mb-0">
        <thead>
          <tr>
            <th>Tiêu đề</th>
            <th>Thời gian</th>
            <th>Đăng ký</th>
            <th>Trạng thái</th>
            <th class="text-end">Hành động</th>
          </tr>
        </thead>
        <tbody>
          @forelse($seminars as $s)
            <tr>
              <td>
                <div style="font-weight:600">{{ $s->title }}</div>
                <div style="font-size:.75rem;color:var(--text-muted)">{{ Str::limit($s->speaker, 30) }}</div>
              </td>
              <td>
                <div style="font-weight:500">{{ $s->starts_at->format('d/m/Y') }}</div>
                <div style="font-size:.75rem;color:var(--text-muted)">{{ $s->starts_at->format('H:i') }} – {{ $s->ends_at->format('H:i') }}</div>
              </td>
              <td>
                @php $pct = min(100, round($s->registrations_count / max(1, $s->capacity) * 100)); @endphp
                <div style="font-weight:600;font-size:.875rem">{{ $s->registrations_count }}/{{ $s->capacity }}</div>
                <div class="capacity-bar mt-1" style="width:60px;height:4px">
                  <div class="capacity-bar-fill {{ $pct >= 90 ? 'full' : ($pct >= 70 ? 'nearly-full' : '') }}" style="width:{{ $pct }}%"></div>
                </div>
              </td>
              <td>
                @if($s->status === 'open')
                  <span class="badge-open"><i class="bi bi-check-circle-fill me-1"></i>Đang mở</span>
                @else
                  <span class="badge-cancelled"><i class="bi bi-x-circle-fill me-1"></i>Đã hủy</span>
                @endif
              </td>
              <td class="text-end text-nowrap">
                <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.seminars.show', $s) }}" style="border-radius:8px;font-size:.78rem;border-color:var(--border)">
                  <i class="bi bi-people-fill me-1"></i>Danh sách
                </a>
                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.seminars.edit', $s) }}" style="border-radius:8px;font-size:.78rem">
                  <i class="bi bi-pencil me-1"></i>Sửa
                </a>
                <form class="d-inline" method="post" action="{{ route('admin.seminars.destroy', $s) }}" onsubmit="return confirm('Xóa seminar này và toàn bộ lượt đăng ký?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger" style="border-radius:8px;font-size:.78rem">
                    <i class="bi bi-trash3 me-1"></i>Xóa
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center py-5" style="color:var(--text-muted)">
                <i class="bi bi-calendar-plus" style="font-size:2rem;display:block;margin-bottom:.5rem"></i>
                Chưa có seminar. Bấm "Đăng seminar mới" để bắt đầu.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="mt-3">{{ $seminars->links('pagination::bootstrap-5') }}</div>
</div>
@endsection
