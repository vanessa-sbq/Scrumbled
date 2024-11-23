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

    public function findUser(Request $request){
        $search = $request->input('search');
        $status = $request->input('status');

        $users = AuthenticatedUser::query()
                 ->when($search, function ($query, $search) {
                    return $query->where(function ($query) use ($search) { 
                                $query->where('username', 'like', "%{$search}%") 
                                      ->orWhere('full_name', 'like', "%{$search}%")
                                      ->orWhere('email', 'like', "%{$search}%");
                    });
                 })
                 ->when($status, function ($query, $status) {
                    return $query->where('status', $status);
                 })
                 ->get();

        return view('admin.sections.user.index', compact('users'));
    }

    public function show($username)
    {
        $user = AuthenticatedUser::where('username', $username)->firstOrFail();
        $projects = $user->allProjects();
        return view('admin.sections.user.show', compact('user', 'projects'));
    }

    public function showEdit($username){
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
            $picturePath = $request->file('picture')->store('public/img/users', 'public');
            $data['picture'] = $picturePath;
        }

        // Edit the user's profile
        $user->update($data);

        // Redirect to the login page with a success message
        return redirect()->route('admin.users.show', $user->username)->with('success', 'Profile edited successfully');
   
    }
}
