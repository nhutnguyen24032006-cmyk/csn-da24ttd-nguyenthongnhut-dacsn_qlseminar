<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Seminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SeminarController extends Controller
{
    public function index(Request $request)
    {
        $q = Seminar::with('category')->withCount('registrations')->where('ends_at', '>=', now());
        if ($kw = $request->input('q')) {
            $q->where(fn ($w) => $w->where('title', 'like', "%$kw%")->orWhere('speaker', 'like', "%$kw%"));
        }
        if ($request->filled('category')) {
            $q->where('category_id', $request->input('category'));
        }
        return view('seminars.index', [
            'seminars' => $q->orderBy('starts_at')->paginate(9)->withQueryString(),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function show(Seminar $seminar)
    {
        $seminar->loadCount('registrations')->load('category');
        $joined = Auth::check() && $seminar->registrations()->where('user_id', Auth::id())->exists();
        return view('seminars.show', compact('seminar', 'joined'));
    }

    public function register(Seminar $seminar)
    {
        $result = DB::transaction(function () use ($seminar) {
            $s = Seminar::lockForUpdate()->findOrFail($seminar->id);
            if ($s->status !== 'open' || now()->gte($s->register_until)) return 'Seminar này đã đóng đăng ký.';
            if ($s->registrations()->where('user_id', Auth::id())->exists()) return 'Bạn đã đăng ký seminar này rồi.';
            if ($s->registrations()->count() >= $s->capacity) return 'Seminar đã hết chỗ.';
            $s->registrations()->create(['user_id' => Auth::id()]);
            return true;
        });
        return $result === true
            ? back()->with('ok', 'Đăng ký thành công! Hẹn gặp bạn tại buổi seminar.')
            : back()->with('err', $result);
    }

    public function cancel(Seminar $seminar)
    {
        if (now()->gte($seminar->starts_at)) {
            return back()->with('err', 'Seminar đã bắt đầu, không thể hủy đăng ký.');
        }
        $seminar->registrations()->where('user_id', Auth::id())->delete();
        return back()->with('ok', 'Đã hủy đăng ký.');
    }
}
