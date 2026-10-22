<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Seminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeminarController extends Controller
{
    private function rules(?Seminar $s = null): array
    {
        $min = $s ? max(1, $s->registrations()->count()) : 1;
        return [
            'title' => 'required|string|max:200',
            'category_id' => 'nullable|exists:categories,id',
            'speaker' => 'required|string|max:150',
            'location' => 'required|string|max:150',
            'description' => 'required|string',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
            'register_until' => 'required|date|before_or_equal:starts_at',
            'capacity' => "required|integer|min:$min|max:5000",
            'status' => 'required|in:open,cancelled',
        ];
    }

    public function index()
    {
        return view('admin.index', ['seminars' => Seminar::withCount('registrations')->orderByDesc('starts_at')->paginate(10)]);
    }

    public function create()
    {
        return view('admin.form', ['seminar' => new Seminar(['capacity' => 50, 'status' => 'open']), 'categories' => Category::orderBy('name')->get()]);
    }

    public function store(Request $request)
    {
        Seminar::create($request->validate($this->rules()) + ['created_by' => Auth::id()]);
        return redirect()->route('admin.seminars.index')->with('ok', 'Đã đăng seminar mới.');
    }

    public function show(Seminar $seminar)
    {
        return view('admin.show', ['seminar' => $seminar, 'regs' => $seminar->registrations()->with('user')->latest()->get()]);
    }

    public function edit(Seminar $seminar)
    {
        return view('admin.form', ['seminar' => $seminar, 'categories' => Category::orderBy('name')->get()]);
    }

    public function update(Request $request, Seminar $seminar)
    {
        $seminar->update($request->validate($this->rules($seminar)));
        return redirect()->route('admin.seminars.index')->with('ok', 'Đã lưu thay đổi.');
    }

    public function destroy(Seminar $seminar)
    {
        $seminar->delete();
        return redirect()->route('admin.seminars.index')->with('ok', 'Đã xóa seminar.');
    }
}
