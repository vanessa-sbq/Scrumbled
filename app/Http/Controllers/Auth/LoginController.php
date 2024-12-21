<?php
 
namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\DB;
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
            $user = Auth::user();
            if($user->isBanned()) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'This account is currently banned.',
                ])->onlyInput('email');
            }

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

    public function sendResetLink(Request $request) {
        $count = AuthenticatedUser::where('email', $request->email)->count();
        if ($count > 0){
            $token = bin2hex(random_bytes(32)); // Generate a token
            $expires_at = now()->addHour(); // Expires 1 hour from now
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'expires_at' => $expires_at
            ]);

            $user = AuthenticatedUser::where('email', $request->email)->first();
            $user->reset_link = url()->current() . '/reset-password?token=' . $token;
            Mail::to($user->email)->send(new ForgotPasswordMail($user, $token));
            return redirect()->back()->with('success', 'Password has been sent to email');
        } else {
            return redirect()->back()->with('error', 'Email not found');
        }
    }

    public function resetForm(){
        return view('web.sections.auth.resetPassword');
    }

    public function resetPassword(Request $request){

        $request->validate([
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $resetData = DB::table('password_resets')->where('token', $request->token)->first();
        if (!$resetData) {
            return redirect()->back()->with('error', 'Invalid token');
        }

        if (strtotime($resetData->expires_at) < time()) {
            return redirect()->back()->with('error', 'Token has expired');
        }

        $user = AuthenticatedUser::where('email', $resetData->email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_resets')
            ->where('email', $resetData->email)
            ->delete();

        return redirect()->route('login')->with('success', 'Password has been reset successfully');
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
