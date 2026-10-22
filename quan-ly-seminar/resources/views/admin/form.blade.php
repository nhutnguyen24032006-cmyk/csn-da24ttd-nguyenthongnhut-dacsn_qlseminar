@extends('layouts.app')
@section('title', $seminar->exists ? 'Sửa seminar: ' . $seminar->title : 'Đăng seminar mới')
@section('content')
<div class="container py-4" style="max-width: 900px;">
  {{-- Breadcrumb --}}
  <nav class="mb-3">
    <a href="{{ route('admin.seminars.index') }}" class="text-decoration-none" style="font-size:.85rem;color:var(--text-secondary)">
      <i class="bi bi-arrow-left me-1"></i> Quay lại danh sách quản lý
    </a>
  </nav>

  {{-- Page Header --}}
  <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div class="d-flex align-items-center gap-3">
      <div style="width:50px;height:50px;background:linear-gradient(135deg,var(--primary),#818cf8);border-radius:14px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.4rem;box-shadow:0 6px 18px var(--primary-glow)">
        <i class="bi {{ $seminar->exists ? 'bi-pencil-square' : 'bi-calendar-plus' }}"></i>
      </div>
      <div>
        <h3 style="font-weight:800;letter-spacing:-.02em;margin-bottom:.15rem">
          {{ $seminar->exists ? 'Chỉnh sửa seminar' : 'Đăng seminar mới' }}
        </h3>
        <p style="color:var(--text-secondary);font-size:.85rem;margin:0">
          {{ $seminar->exists ? 'Cập nhật nội dung, lịch trình hoặc số lượng người tham dự' : 'Điền thông tin chi tiết để công bố buổi seminar tới sinh viên & giảng viên' }}
        </p>
      </div>
    </div>
    @if($seminar->exists)
      <a href="{{ route('admin.seminars.show', $seminar) }}" class="btn-ghost" style="color:var(--text);border-color:var(--border);background:var(--surface)">
        <i class="bi bi-people me-1"></i> Xem {{ $seminar->registrations()->count() }} người đăng ký
      </a>
    @endif
  </div>

  <form method="post" action="{{ $seminar->exists ? route('admin.seminars.update', $seminar) : route('admin.seminars.store') }}">
    @csrf
    @if($seminar->exists)
      @method('PUT')
    @endif

    {{-- Section 1: Basic Info --}}
    <div class="panel mb-4">
      <div class="d-flex align-items-center gap-2 mb-3 pb-2" style="border-bottom: 1px solid var(--border)">
        <span style="width:26px;height:26px;background:rgba(99,102,241,.12);color:var(--primary);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:700">1</span>
        <h5 style="font-weight:700;font-size:1rem;margin:0">Thông tin cơ bản</h5>
      </div>

      <div class="row g-3">
        <div class="col-12">
          <label class="form-label" style="font-size:.8rem;font-weight:600">Tên buổi seminar <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text" style="background:var(--paper);border-color:var(--border);color:var(--text-muted)"><i class="bi bi-type-h1"></i></span>
            <input type="text" name="title" value="{{ old('title', $seminar->title) }}" placeholder="Ví dụ: Ứng dụng Trí tuệ Nhân tạo trong Phát triển Phần mềm Hiện đại" class="form-control @error('title') is-invalid @enderror" style="border-color:var(--border)">
            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="col-md-6">
          <label class="form-label" style="font-size:.8rem;font-weight:600">Diễn giả / Báo cáo viên <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text" style="background:var(--paper);border-color:var(--border);color:var(--text-muted)"><i class="bi bi-person-badge"></i></span>
            <input type="text" name="speaker" value="{{ old('speaker', $seminar->speaker) }}" placeholder="Ví dụ: PGS. TS. Nguyễn Văn A hoặc Kỹ sư Google" class="form-control @error('speaker') is-invalid @enderror" style="border-color:var(--border)">
            @error('speaker')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="col-md-6">
          <label class="form-label" style="font-size:.8rem;font-weight:600">Chủ đề chuyên môn</label>
          <div class="input-group">
            <span class="input-group-text" style="background:var(--paper);border-color:var(--border);color:var(--text-muted)"><i class="bi bi-tag"></i></span>
            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" style="border-color:var(--border)">
              <option value="">Chưa phân loại</option>
              @foreach($categories as $c)
                <option value="{{ $c->id }}" @selected(old('category_id', $seminar->category_id) == $c->id)>{{ $c->name }}</option>
              @endforeach
            </select>
            @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="col-12">
          <label class="form-label" style="font-size:.8rem;font-weight:600">Địa điểm tổ chức <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text" style="background:var(--paper);border-color:var(--border);color:var(--text-muted)"><i class="bi bi-geo-alt"></i></span>
            <input type="text" name="location" value="{{ old('location', $seminar->location) }}" placeholder="Ví dụ: Hội trường E3 - Tầng 2 hoặc Trực tuyến qua Google Meet" class="form-control @error('location') is-invalid @enderror" style="border-color:var(--border)">
            @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>
      </div>
    </div>

    {{-- Section 2: Time, Slots & Status --}}
    <div class="panel mb-4">
      <div class="d-flex align-items-center gap-2 mb-3 pb-2" style="border-bottom: 1px solid var(--border)">
        <span style="width:26px;height:26px;background:rgba(99,102,241,.12);color:var(--primary);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:700">2</span>
        <h5 style="font-weight:700;font-size:1rem;margin:0">Thời gian, Quy mô & Trạng thái</h5>
      </div>

      <div class="row g-3">
        <div class="col-md-4">
          <label class="form-label" style="font-size:.8rem;font-weight:600">Thời gian bắt đầu <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text" style="background:var(--paper);border-color:var(--border);color:var(--text-muted)"><i class="bi bi-calendar-event"></i></span>
            <input type="datetime-local" name="starts_at" value="{{ old('starts_at', optional($seminar->starts_at)->format('Y-m-d\TH:i')) }}" class="form-control @error('starts_at') is-invalid @enderror" style="border-color:var(--border)">
            @error('starts_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="col-md-4">
          <label class="form-label" style="font-size:.8rem;font-weight:600">Thời gian kết thúc <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text" style="background:var(--paper);border-color:var(--border);color:var(--text-muted)"><i class="bi bi-calendar-check"></i></span>
            <input type="datetime-local" name="ends_at" value="{{ old('ends_at', optional($seminar->ends_at)->format('Y-m-d\TH:i')) }}" class="form-control @error('ends_at') is-invalid @enderror" style="border-color:var(--border)">
            @error('ends_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="col-md-4">
          <label class="form-label" style="font-size:.8rem;font-weight:600">Hạn chót đăng ký <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text" style="background:var(--paper);border-color:var(--border);color:var(--text-muted)"><i class="bi bi-stopwatch"></i></span>
            <input type="datetime-local" name="register_until" value="{{ old('register_until', optional($seminar->register_until)->format('Y-m-d\TH:i')) }}" class="form-control @error('register_until') is-invalid @enderror" style="border-color:var(--border)">
            @error('register_until')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="form-text" style="font-size:.72rem;color:var(--text-muted)">Phải trước hoặc bằng thời gian bắt đầu.</div>
        </div>

        <div class="col-md-6">
          <label class="form-label" style="font-size:.8rem;font-weight:600">Số lượng chỗ tối đa <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text" style="background:var(--paper);border-color:var(--border);color:var(--text-muted)"><i class="bi bi-people"></i></span>
            <input type="number" name="capacity" min="{{ $seminar->exists ? max(1, $seminar->registrations()->count()) : 1 }}" max="5000" value="{{ old('capacity', $seminar->capacity ?? 50) }}" class="form-control @error('capacity') is-invalid @enderror" style="border-color:var(--border)">
            @error('capacity')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          @if($seminar->exists)
            <div class="form-text" style="font-size:.72rem;color:var(--text-muted)">Hiện đã có {{ $seminar->registrations()->count() }} người đăng ký, không thể giảm nhỏ hơn số này.</div>
          @endif
        </div>

        <div class="col-md-6">
          <label class="form-label" style="font-size:.8rem;font-weight:600">Trạng thái đăng ký <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text" style="background:var(--paper);border-color:var(--border);color:var(--text-muted)"><i class="bi bi-toggle-on"></i></span>
            <select name="status" class="form-select @error('status') is-invalid @enderror" style="border-color:var(--border)">
              <option value="open" @selected(old('status', $seminar->status) === 'open')>Đang mở cho đăng ký</option>
              <option value="cancelled" @selected(old('status', $seminar->status) === 'cancelled')>Đã hủy buổi seminar này</option>
            </select>
            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>
      </div>
    </div>

    {{-- Section 3: Description --}}
    <div class="panel mb-4">
      <div class="d-flex align-items-center gap-2 mb-3 pb-2" style="border-bottom: 1px solid var(--border)">
        <span style="width:26px;height:26px;background:rgba(99,102,241,.12);color:var(--primary);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:700">3</span>
        <h5 style="font-weight:700;font-size:1rem;margin:0">Nội dung chi tiết</h5>
      </div>

      <div class="mb-2">
        <label class="form-label" style="font-size:.8rem;font-weight:600">Giới thiệu về nội dung, mục tiêu và agenda <span class="text-danger">*</span></label>
        <textarea name="description" rows="7" placeholder="Mô tả chi tiết nội dung seminar, đối tượng phù hợp, kiến thức cần chuẩn bị và lịch trình các phần trình bày..." class="form-control @error('description') is-invalid @enderror" style="border-color:var(--border);line-height:1.6">{{ old('description', $seminar->description) }}</textarea>
        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
    </div>

    {{-- Actions --}}
    <div class="d-flex align-items-center justify-content-between pt-2">
      <a class="btn" href="{{ route('admin.seminars.index') }}" style="background:var(--paper);border:1px solid var(--border);color:var(--text-secondary);font-weight:600;font-size:.875rem;padding:.55rem 1.25rem;border-radius:var(--radius-sm)">
        <i class="bi bi-x me-1"></i> Hủy & Quay lại
      </a>
      <button type="submit" class="btn-primary-custom" style="padding:.65rem 1.75rem;font-size:.9rem">
        <i class="bi {{ $seminar->exists ? 'bi-check2' : 'bi-send' }} me-1"></i>
        {{ $seminar->exists ? 'Lưu thay đổi' : 'Đăng seminar' }}
      </button>
    </div>
  </form>
</div>
@endsection
