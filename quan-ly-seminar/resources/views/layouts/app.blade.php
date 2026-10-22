<!doctype html>
<html lang="vi">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'Seminar khoa Công nghệ thông tin')</title>
<meta name="description" content="Website đăng ký và quản lý seminar học thuật - Khoa Công nghệ thông tin">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<style>
/* ─── Design Tokens ─── */
:root {
  --ink: #0f172a;
  --ink-light: #1e293b;
  --ink-softer: #334155;
  --primary: #6366f1;
  --primary-hover: #4f46e5;
  --primary-glow: rgba(99,102,241,.25);
  --accent: #f59e0b;
  --accent-soft: rgba(245,158,11,.15);
  --success: #10b981;
  --success-soft: rgba(16,185,129,.12);
  --danger: #ef4444;
  --danger-soft: rgba(239,68,68,.12);
  --paper: #f8fafc;
  --surface: #ffffff;
  --border: #e2e8f0;
  --border-hover: #cbd5e1;
  --text: #0f172a;
  --text-secondary: #64748b;
  --text-muted: #94a3b8;
  --radius: 16px;
  --radius-sm: 10px;
  --shadow-sm: 0 1px 2px rgba(0,0,0,.05);
  --shadow: 0 4px 16px rgba(0,0,0,.06);
  --shadow-lg: 0 12px 40px rgba(0,0,0,.1);
  --shadow-glow: 0 0 40px var(--primary-glow);
  --transition: .2s cubic-bezier(.4,0,.2,1);
}

/* ─── Global Reset ─── */
*{box-sizing:border-box}
body {
  font-family:'Inter',system-ui,-apple-system,sans-serif;
  background: var(--paper);
  color: var(--text);
  line-height: 1.6;
  -webkit-font-smoothing: antialiased;
}

/* ─── Navbar ─── */
.navbar-custom {
  background: var(--ink);
  border-bottom: 1px solid rgba(255,255,255,.06);
  padding: .75rem 0;
  position: sticky;
  top: 0;
  z-index: 100;
  backdrop-filter: blur(20px);
}
.navbar-custom .navbar-brand {
  color: #fff !important;
  font-weight: 800;
  font-size: 1.1rem;
  letter-spacing: -.01em;
  display: flex;
  align-items: center;
  gap: .55rem;
}
.navbar-custom .brand-icon {
  width: 34px; height: 34px;
  background: linear-gradient(135deg, var(--primary), #818cf8);
  border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  font-size: 1rem;
  box-shadow: 0 4px 12px rgba(99,102,241,.3);
}
.navbar-custom .nav-link {
  color: rgba(255,255,255,.7) !important;
  font-weight: 500;
  font-size: .875rem;
  transition: color var(--transition);
  padding: .4rem .75rem !important;
  border-radius: 8px;
}
.navbar-custom .nav-link:hover {
  color: #fff !important;
  background: rgba(255,255,255,.08);
}
.nav-user {
  display: flex; align-items: center; gap: .5rem;
  padding: .3rem .4rem .3rem .8rem;
  background: rgba(255,255,255,.08);
  border-radius: 20px;
  border: 1px solid rgba(255,255,255,.08);
}
.nav-user-avatar {
  width: 28px; height: 28px;
  background: linear-gradient(135deg, var(--primary), #818cf8);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  color: #fff;
  font-size: .7rem;
  font-weight: 700;
}
.nav-user-name {
  color: rgba(255,255,255,.85);
  font-size: .8rem;
  font-weight: 500;
}

/* ─── Buttons ─── */
.btn-primary-custom {
  background: linear-gradient(135deg, var(--primary), #818cf8);
  border: none;
  color: #fff;
  font-weight: 600;
  padding: .55rem 1.25rem;
  border-radius: var(--radius-sm);
  transition: all var(--transition);
  box-shadow: 0 2px 8px rgba(99,102,241,.25);
  font-size: .875rem;
}
.btn-primary-custom:hover {
  background: linear-gradient(135deg, var(--primary-hover), #6366f1);
  transform: translateY(-1px);
  box-shadow: 0 6px 20px rgba(99,102,241,.35);
  color: #fff;
}
.btn-primary-custom:active {
  transform: translateY(0);
}
.btn-ghost {
  background: transparent;
  border: 1px solid rgba(255,255,255,.2);
  color: #fff;
  font-weight: 500;
  padding: .4rem 1rem;
  border-radius: var(--radius-sm);
  transition: all var(--transition);
  font-size: .8rem;
}
.btn-ghost:hover {
  background: rgba(255,255,255,.1);
  border-color: rgba(255,255,255,.3);
  color: #fff;
}

/* ─── Hero Section ─── */
.hero {
  background: linear-gradient(160deg, var(--ink) 0%, #1e1b4b 50%, #312e81 100%);
  color: #fff;
  padding: 4rem 0 5.5rem;
  position: relative;
  overflow: hidden;
}
.hero::before {
  content: '';
  position: absolute;
  top: -120px; right: -60px;
  width: 400px; height: 400px;
  background: radial-gradient(circle, rgba(99,102,241,.2) 0%, transparent 70%);
  border-radius: 50%;
  pointer-events: none;
}
.hero::after {
  content: '';
  position: absolute;
  bottom: -80px; left: 10%;
  width: 300px; height: 300px;
  background: radial-gradient(circle, rgba(245,158,11,.1) 0%, transparent 70%);
  border-radius: 50%;
  pointer-events: none;
}
.hero h1 {
  font-weight: 900;
  letter-spacing: -.03em;
  font-size: clamp(2rem, 5vw, 3rem);
  line-height: 1.15;
  max-width: 18ch;
  position: relative;
}
.hero .lead {
  color: rgba(255,255,255,.6);
  font-size: 1.05rem;
  max-width: 40ch;
}
.hero-badge {
  display: inline-flex;
  align-items: center;
  gap: .4rem;
  padding: .3rem .75rem;
  background: rgba(99,102,241,.2);
  border: 1px solid rgba(99,102,241,.25);
  border-radius: 20px;
  color: #a5b4fc;
  font-size: .78rem;
  font-weight: 600;
  margin-bottom: 1rem;
}
.hero-badge .dot {
  width: 6px; height: 6px;
  background: var(--success);
  border-radius: 50%;
  animation: pulse-dot 2s ease infinite;
}
@keyframes pulse-dot {
  0%,100% { opacity: 1; transform: scale(1); }
  50% { opacity: .5; transform: scale(1.3); }
}

/* ─── Search Bar ─── */
.search-bar {
  background: var(--surface);
  border-radius: var(--radius);
  padding: .5rem;
  margin-top: -2rem;
  box-shadow: var(--shadow-lg);
  position: relative;
  z-index: 10;
  border: 1px solid var(--border);
}
.search-bar .form-control,
.search-bar .form-select {
  border: none;
  background: var(--paper);
  border-radius: var(--radius-sm);
  font-size: .9rem;
  padding: .65rem 1rem;
  transition: all var(--transition);
}
.search-bar .form-control:focus,
.search-bar .form-select:focus {
  background: #fff;
  box-shadow: 0 0 0 3px var(--primary-glow);
}

/* ─── Seminar Cards ─── */
.seminar-card {
  background: var(--surface);
  border-radius: var(--radius);
  border: 1px solid var(--border);
  overflow: hidden;
  transition: all .25s cubic-bezier(.4,0,.2,1);
  height: 100%;
  display: flex;
  flex-direction: column;
}
.seminar-card:hover {
  border-color: var(--primary);
  box-shadow: var(--shadow), var(--shadow-glow);
  transform: translateY(-4px);
}
.seminar-card-date {
  background: linear-gradient(135deg, var(--ink), #1e1b4b);
  color: #fff;
  padding: 1rem;
  text-align: center;
  position: relative;
}
.seminar-card-date .month {
  font-size: .65rem;
  text-transform: uppercase;
  letter-spacing: .1em;
  color: rgba(255,255,255,.5);
  font-weight: 600;
}
.seminar-card-date .day {
  font-size: 2rem;
  font-weight: 900;
  line-height: 1.1;
  background: linear-gradient(135deg, #fff, #a5b4fc);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}
.seminar-card-date .time {
  font-size: .75rem;
  color: var(--accent);
  font-weight: 600;
}
.seminar-card-body {
  padding: 1.15rem;
  flex: 1;
  display: flex;
  flex-direction: column;
}
.seminar-card-body .category-tag {
  display: inline-flex;
  align-items: center;
  gap: .3rem;
  padding: .2rem .6rem;
  background: var(--primary-glow);
  color: var(--primary);
  font-size: .7rem;
  font-weight: 600;
  border-radius: 6px;
  margin-bottom: .55rem;
  width: fit-content;
}
.seminar-card-body h5 {
  font-weight: 700;
  font-size: .95rem;
  margin-bottom: .4rem;
  line-height: 1.35;
  letter-spacing: -.01em;
}
.seminar-card-body h5 a {
  color: var(--text);
  text-decoration: none;
  transition: color var(--transition);
}
.seminar-card-body h5 a:hover { color: var(--primary); }
.seminar-card-meta {
  font-size: .78rem;
  color: var(--text-secondary);
  margin-bottom: .75rem;
}
.seminar-card-meta i { color: var(--text-muted); margin-right: .2rem; }
.seminar-card-footer {
  margin-top: auto;
  padding-top: .75rem;
  border-top: 1px solid var(--border);
}

/* ─── Progress Bar ─── */
.capacity-bar {
  height: 5px;
  background: var(--border);
  border-radius: 20px;
  overflow: hidden;
  margin-bottom: .35rem;
}
.capacity-bar-fill {
  height: 100%;
  border-radius: 20px;
  background: linear-gradient(90deg, var(--primary), #818cf8);
  transition: width .5s ease;
}
.capacity-bar-fill.nearly-full {
  background: linear-gradient(90deg, var(--accent), #fbbf24);
}
.capacity-bar-fill.full {
  background: linear-gradient(90deg, var(--danger), #f87171);
}
.capacity-text {
  font-size: .73rem;
  color: var(--text-muted);
  font-weight: 500;
}
.status-cancelled {
  font-size: .73rem;
  color: var(--danger);
  font-weight: 600;
}

/* ─── Panel / Card Container ─── */
.panel {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 1.75rem;
  box-shadow: var(--shadow-sm);
}
.panel-glass {
  background: rgba(255,255,255,.7);
  backdrop-filter: blur(12px);
  border: 1px solid rgba(255,255,255,.8);
}

/* ─── Detail Page ─── */
.detail-info-row {
  display: flex;
  align-items: flex-start;
  gap: .75rem;
  padding: .65rem 0;
}
.detail-info-row:not(:last-child) {
  border-bottom: 1px solid var(--border);
}
.detail-info-icon {
  width: 36px; height: 36px;
  border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  font-size: .9rem;
  flex-shrink: 0;
}
.detail-info-icon.calendar { background: var(--primary-glow); color: var(--primary); }
.detail-info-icon.location { background: var(--success-soft); color: var(--success); }
.detail-info-icon.deadline { background: var(--accent-soft); color: var(--accent); }
.detail-info-icon.people   { background: rgba(99,102,241,.1); color: var(--primary); }

/* ─── Status Badges ─── */
.badge-open {
  background: var(--success-soft);
  color: #059669;
  font-weight: 600;
  font-size: .75rem;
  padding: .3rem .65rem;
  border-radius: 6px;
}
.badge-cancelled {
  background: var(--danger-soft);
  color: var(--danger);
  font-weight: 600;
  font-size: .75rem;
  padding: .3rem .65rem;
  border-radius: 6px;
}

/* ─── Tables (Admin) ─── */
.table-custom thead th {
  background: var(--paper);
  font-size: .75rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: .05em;
  color: var(--text-secondary);
  border-bottom: 1px solid var(--border);
  padding: .85rem 1rem;
}
.table-custom tbody td {
  padding: .85rem 1rem;
  vertical-align: middle;
  font-size: .875rem;
  border-bottom: 1px solid var(--border);
}
.table-custom tbody tr {
  transition: background var(--transition);
}
.table-custom tbody tr:hover {
  background: var(--paper);
}

/* ─── Auth Forms ─── */
.auth-wrapper {
  min-height: calc(100vh - 160px);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 2rem 1rem;
}
.auth-card {
  width: 100%;
  max-width: 440px;
}
.auth-card .panel {
  padding: 2.5rem;
}
.auth-card h3 {
  font-weight: 800;
  letter-spacing: -.02em;
  margin-bottom: .25rem;
}
.auth-card .subtitle {
  color: var(--text-secondary);
  font-size: .875rem;
  margin-bottom: 1.5rem;
}
.auth-card .form-control {
  border-radius: var(--radius-sm);
  border: 1px solid var(--border);
  padding: .65rem .9rem;
  font-size: .875rem;
  transition: all var(--transition);
}
.auth-card .form-control:focus {
  border-color: var(--primary);
  box-shadow: 0 0 0 3px var(--primary-glow);
}
.auth-card .form-label {
  font-size: .8rem;
  font-weight: 600;
  color: var(--text);
}

/* ─── Alerts ─── */
.alert-float {
  position: fixed;
  top: 80px;
  right: 1rem;
  z-index: 200;
  max-width: 400px;
  border: none;
  border-radius: var(--radius-sm);
  box-shadow: var(--shadow-lg);
  font-size: .875rem;
  font-weight: 500;
  animation: slideIn .35s cubic-bezier(.4,0,.2,1) both;
  padding: .85rem 1.25rem;
}
.alert-float.alert-success {
  background: #ecfdf5;
  color: #065f46;
  border-left: 4px solid var(--success);
}
.alert-float.alert-danger {
  background: #fef2f2;
  color: #991b1b;
  border-left: 4px solid var(--danger);
}
@keyframes slideIn {
  from { opacity: 0; transform: translateX(30px); }
  to   { opacity: 1; transform: none; }
}

/* ─── Footer ─── */
.footer-custom {
  border-top: 1px solid var(--border);
  padding: 2rem 0;
  margin-top: 3rem;
  text-align: center;
}
.footer-custom p {
  color: var(--text-muted);
  font-size: .8rem;
  margin: 0;
}

/* ─── Page Enter Animation ─── */
.page-enter {
  animation: pageEnter .4s cubic-bezier(.4,0,.2,1) both;
}
@keyframes pageEnter {
  from { opacity: 0; transform: translateY(10px); }
  to   { opacity: 1; transform: none; }
}

/* ─── Accessibility ─── */
a:focus-visible, button:focus-visible, input:focus-visible,
select:focus-visible, textarea:focus-visible {
  outline: 3px solid var(--primary);
  outline-offset: 2px;
}
@media (prefers-reduced-motion: reduce) {
  *, *::before, *::after {
    animation-duration: 0.01ms !important;
    transition-duration: 0.01ms !important;
  }
}

/* ─── Responsive ─── */
@media (max-width: 768px) {
  .hero { padding: 2.5rem 0 3.5rem; }
  .hero h1 { font-size: 1.75rem; }
  .auth-card .panel { padding: 1.75rem; }
  .seminar-card-date { padding: .75rem; }
  .seminar-card-date .day { font-size: 1.6rem; }
}

/* ─── Scrollbar ─── */
::-webkit-scrollbar { width: 8px; }
::-webkit-scrollbar-track { background: var(--paper); }
::-webkit-scrollbar-thumb { background: var(--border-hover); border-radius: 4px; }
::-webkit-scrollbar-thumb:hover { background: var(--text-muted); }
</style>
</head>
<body>
{{-- ─── Navbar ─── --}}
<nav class="navbar-custom">
  <div class="container d-flex align-items-center">
    <a class="navbar-brand" href="{{ route('home') }}">
      <span class="brand-icon"><i class="bi bi-mortarboard-fill"></i></span>
      <span class="d-none d-sm-inline">Seminar CNTT</span>
    </a>
    <div class="ms-auto d-flex align-items-center gap-2">
      @auth
        @if(auth()->user()->isAdmin())
          <a class="nav-link" href="{{ route('admin.seminars.index') }}">
            <i class="bi bi-grid-1x2-fill"></i><span class="d-none d-md-inline ms-1">Quản trị</span>
          </a>
        @endif
        <div class="nav-user">
          <span class="nav-user-name d-none d-sm-inline">{{ auth()->user()->name }}</span>
          <div class="nav-user-avatar">{{ mb_substr(auth()->user()->name, 0, 1) }}</div>
        </div>
        <form method="post" action="{{ route('logout') }}">@csrf
          <button class="btn-ghost" title="Đăng xuất"><i class="bi bi-box-arrow-right"></i></button>
        </form>
      @else
        <a class="nav-link" href="{{ route('login') }}">Đăng nhập</a>
        <a class="btn-primary-custom text-decoration-none" href="{{ route('register') }}">
          <i class="bi bi-person-plus-fill me-1"></i>Tạo tài khoản
        </a>
      @endauth
    </div>
  </div>
</nav>

{{-- ─── Flash Messages ─── --}}
@if(session('ok'))
  <div class="alert alert-float alert-success" id="flash-ok">
    <i class="bi bi-check-circle-fill me-1"></i>{{ session('ok') }}
  </div>
@endif
@if(session('err'))
  <div class="alert alert-float alert-danger" id="flash-err">
    <i class="bi bi-exclamation-circle-fill me-1"></i>{{ session('err') }}
  </div>
@endif

{{-- ─── Main Content ─── --}}
<main class="page-enter">
  @yield('content')
</main>

{{-- ─── Footer ─── --}}
<footer class="footer-custom">
  <div class="container">
    <p><i class="bi bi-mortarboard me-1"></i>Đồ án cơ sở ngành · Website quản lý và đăng ký seminar học thuật</p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Auto-dismiss flash messages
document.querySelectorAll('.alert-float').forEach(el => {
  setTimeout(() => {
    el.style.transition = 'opacity .3s, transform .3s';
    el.style.opacity = '0';
    el.style.transform = 'translateX(30px)';
    setTimeout(() => el.remove(), 300);
  }, 4000);
});
</script>
</body>
</html>
