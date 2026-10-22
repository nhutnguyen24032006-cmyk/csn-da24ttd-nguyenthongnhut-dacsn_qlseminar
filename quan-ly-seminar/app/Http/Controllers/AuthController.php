<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() { return view('auth.login'); }
    public function showRegister() { return view('auth.register'); }

    public function login(Request $request)
    {
        $cred = $request->validate(['email' => 'required|email', 'password' => 'required']);
        if (!Auth::attempt($cred, $request->boolean('remember'))) {
            return back()->withInput($request->only('email'))->withErrors(['email' => 'Email hoặc mật khẩu chưa đúng.']);
        }
        $request->session()->regenerate();
        return redirect()->intended(route('home'));
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email',
            'student_code' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:15',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $data['password'] = Hash::make($data['password']);
        Auth::login(User::create($data));
        $request->session()->regenerate();
        return redirect()->route('home')->with('ok', 'Tạo tài khoản thành công. Chọn một seminar để đăng ký nhé!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
