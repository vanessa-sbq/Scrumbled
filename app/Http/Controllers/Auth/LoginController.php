<?php
 
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AuthenticatedUser;
use Illuminate\Http\Request;
use Hash;
use Mail;
use App\Mail\ForgotPasswordMail;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    /**
     * Display a login form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/projects');
        } else {
            return view('web.sections.auth.login');
        }
    }

    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
 
            return redirect()->intended('/projects');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function forgotPassword() {
        return view('web.sections.auth.forgotPassword');
    }

    public function resetPassword(Request $request) {
        $count = AuthenticatedUser::where('email', $request->email)->count();

        if ($count > 0){
            $user = AuthenticatedUser::where('email', $request->email)->first();
            $randomPass = rand(111111, 999999);
            $user->password = Hash::make($randomPass);
            $user->save();
            $user->random_password = $randomPass;
            Mail::to($user->email)->send(new ForgotPasswordMail($user));
            return redirect()->back()->with('success', 'Password has been sent to email');
        } else {
            return redirect()->back()->with('error', 'Email not found');
        }
    }

    /**
     * Log out the user from application.
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->withSuccess('You have logged out successfully!');
    } 
}
