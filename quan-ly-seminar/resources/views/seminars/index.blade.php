@extends('layouts.app')
@section('content')
{{-- ─── Hero ─── --}}
<section class="hero">
  <div class="container">
    <div class="hero-badge"><span class="dot"></span> Khoa Công nghệ thông tin</div>
    <h1>Seminar học thuật<br>sắp diễn ra</h1>
    <p class="lead mb-0">Khám phá lịch seminar, chọn buổi phù hợp và giữ chỗ chỉ trong vài giây.</p>
  </div>
</section>

{{-- ─── Search ─── --}}
<div class="container">
  <form class="search-bar row g-2 mx-0" method="get" action="{{ route('home') }}">
    <div class="col-md-6">
      <input class="form-control" name="q" value="{{ request('q') }}" placeholder="🔍  Tìm theo tên seminar hoặc diễn giả…">
    </div>
    <div class="col-md-4">
      <select class="form-select" name="category">
        <option value="">📁  Mọi chủ đề</option>
        @foreach($categories as $c)
          <option value="{{ $c->id }}" @selected(request('category') == $c->id)>{{ $c->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-2 d-grid">
      <button class="btn-primary-custom">
        <i class="bi bi-search me-1"></i>Tìm kiếm
      </button>
    </div>
  </form>

  {{-- ─── Seminars Grid ─── --}}
  <div class="row g-4 mt-2 pb-4">
    @forelse($seminars as $s)
      @php
        $pct = min(100, round($s->registrations_count / max(1, $s->capacity) * 100));
        $barClass = $pct >= 90 ? 'full' : ($pct >= 70 ? 'nearly-full' : '');
      @endphp
      <div class="col-md-6 col-xl-4">
        <div class="seminar-card">
          <div class="d-flex h-100">
            <div class="seminar-card-date d-flex flex-column justify-content-center" style="min-width:92px">
              <div class="month">Thg {{ $s->starts_at->format('n') }}</div>
              <div class="day">{{ $s->starts_at->format('d') }}</div>
              <div class="time">{{ $s->starts_at->format('H:i') }}</div>
            </div>
            <div class="seminar-card-body">
              @if($s->category)
                <span class="category-tag"><i class="bi bi-bookmark-fill"></i> {{ $s->category->name }}</span>
              @endif
              <h5><a href="{{ route('seminars.show', $s) }}">{{ $s->title }}</a></h5>
              <div class="seminar-card-meta">
                <div><i class="bi bi-person-fill"></i> {{ $s->speaker }}</div>
                <div><i class="bi bi-geo-alt-fill"></i> {{ $s->location }}</div>
              </div>
              <div class="seminar-card-footer">
                @if($s->status === 'cancelled')
                  <span class="status-cancelled"><i class="bi bi-x-circle-fill"></i> Đã hủy</span>
                @else
                  <div class="capacity-bar">
                    <div class="capacity-bar-fill {{ $barClass }}" style="width:{{ $pct }}%"></div>
                  </div>
                  <span class="capacity-text">Còn {{ $s->seats_left }}/{{ $s->capacity }} chỗ</span>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12">
        <div class="panel text-center py-5">
          <i class="bi bi-calendar-x" style="font-size:2.5rem;color:var(--text-muted)"></i>
          <p class="mt-3 mb-0" style="color:var(--text-secondary)">Chưa có seminar nào phù hợp. Thử bỏ bớt bộ lọc.</p>
        </div>
      </div>
    @endforelse
  </div>

  <div class="pb-3">{{ $seminars->links('pagination::bootstrap-5') }}</div>
</div>
@endsection
