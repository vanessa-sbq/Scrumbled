<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuthenticatedUser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function list()
    {
        $users = AuthenticatedUser::all();
        return view('admin.sections.user.index', compact('users'));
    }

    public function show($username)
    {
        $user = AuthenticatedUser::where('username', $username)->firstOrFail();
        $projects = $user->allProjects();
        return view('admin.sections.user.show', compact('user', 'projects'));
    }

    public function showEdit($username)
    {
        $user = AuthenticatedUser::where('username', $username)->firstOrFail();
        return view('admin.sections.user.edit', compact('user'));
    }

    public function edit($username, Request $request)
    {
        // Find the user by username
        $user = AuthenticatedUser::where('username', $username)->firstOrFail();

        // Validate the request data
        $request->validate([
            // FIXME:  . $user->id
            'username' => 'required|string|max:250|alpha_dash|unique:authenticated_user,username,' . $user->id,
            'email' => 'required|email|max:250|unique:authenticated_user,email,' . $user->id,
            'full_name' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:ACTIVE,NEEDS_CONFIRMATION,BANNED'
        ]);

        // Collect the validated data
        $data = $request->only('username', 'email', 'full_name', 'bio', 'status');

        // Handle the file upload
        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('images/users', 'public');
            $data['picture'] = $picturePath;
        }

        // Edit the user's profile
        $user->update($data);

        // Redirect to the login page with a success message
        return redirect()->route('admin.users.show', $user->username)->with('success', 'Profile edited successfully');
    }

    public function ban($userId)
    {
        $user = AuthenticatedUser::where('id', $userId)->firstOrFail();
        $user->update(['status' => 'BANNED']);
        return redirect()->route('admin.users')->with('success', 'Profile edited successfully');
    }

    public function unban($userId)
    {
        $user = AuthenticatedUser::where('id', $userId)->firstOrFail();
        $user->update(['status' => 'ACTIVE']);
        return redirect()->route('admin.users')->with('success', 'Profile edited successfully');
    }

    public function showCreate(){
        return view('admin.sections.user.create');
    }

    public function createUser(Request $request){
        // Validate the request data
        $request->validate([
            'username' => 'required|string|max:250|alpha_dash|unique:authenticated_user',
            'email' => 'required|email|max:250|unique:authenticated_user',
            'password' => 'required|string|min:8',
            'full_name' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:ACTIVE,BANNED'
        ]);

        // Collect the validated data
        $data = $request->only('username', 'email', 'password', 'full_name', 'bio', 'status');

        // Handle the file upload
        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('images/users', 'public');
            $data['picture'] = $picturePath;
        }

        // Create the user
        $user = AuthenticatedUser::create($data);

        // Redirect to the user's profile page with a success message
        return redirect()->route('admin.users.show', $user->username)->with('success', 'User created successfully');
    }
    
}
