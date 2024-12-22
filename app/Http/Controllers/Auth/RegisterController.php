<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\View\View;

use App\Models\AuthenticatedUser;

class RegisterController extends Controller
{
    /**
     * Display a login form.
     */
    public function showRegistrationForm(): View
    {
        return view('web.sections.auth.register');
    }

    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        // Validate the request data
        $request->validate([
            'username' => 'required|string|max:20|alpha_dash|unique:authenticated_user',
            'email' => 'required|email|max:40|unique:authenticated_user',
            'password' => 'required|min:8|confirmed',
            'full_name' => 'required|string|max:40',
            'bio' => 'nullable|string|max:1000',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Collect the validated data
        $data = $request->only('username', 'email', 'full_name', 'bio', 'full_name');
        $data['password'] = Hash::make($request->password);

        // Handle the file upload
        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('profile_pictures', 'public');
            $data['picture'] = $picturePath;
        }

        // Create the user
        AuthenticatedUser::create($data);

        // Redirect to the login page with a success message
        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }
}
