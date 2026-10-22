<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Seminar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #0f172a; color: #f8fafc; }
        .glass {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="min-h-screen p-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-bold text-cyan-400">Hệ Thống Đăng Ký Seminar</h1>
            <form action="" method="GET" class="flex gap-2">
                <input type="text" name="search" placeholder="Tìm kiếm seminar..." 
                       class="glass px-4 py-2 rounded-lg outline-none focus:border-cyan-400 text-sm w-64">
                <button type="submit" class="bg-cyan-600 hover:bg-cyan-500 px-4 py-2 rounded-lg text-sm font-semibold transition">Tìm</button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($seminars as $seminar)
            <div class="glass p-6 rounded-2xl flex flex-col justify-between">
                <div>
                    <h2 class="text-xl font-bold mb-2">{{ $seminar->title }}</h2>
                    <p class="text-slate-400 text-sm mb-4 line-clamp-3">{{ $seminar->description }}</p>
                    <div class="space-y-2 text-sm text-slate-300">
                        <p>🎤 Diễn giả: <span class="text-white">{{ $seminar->speaker }}</span></p>
                        <p>⏱ Thời gian: <span class="text-white">{{ \Carbon\Carbon::parse($seminar->start_time)->format('d/m/Y H:i') }}</span></p>
                        <p>📍 Địa điểm: <span class="text-white">{{ $seminar->location }}</span></p>
                    </div>
                </div>
                
                <form action="{{ route('seminar.register', $seminar->id) }}" method="POST" class="mt-6">
                    @csrf
                    <button type="submit" class="w-full bg-white/10 hover:bg-cyan-500 hover:text-slate-900 border border-white/20 px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-300">
                        Đăng ký tham dự
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </div>
</body>
</html>