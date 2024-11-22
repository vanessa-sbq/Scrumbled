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
        $users = AuthenticatedUser::query()
                 ->when($search, function ($query, $search) {
                    return $query->where('username', 'like', "%{$search}%")
                                 ->orWhere('full_name', 'like', "%{$search}%")
                                 ->orWhere('email', 'like', "%{$search}%");
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

    public function edit($username)
    {
        $user = AuthenticatedUser::where('username', $username)->firstOrFail();
        return view('admin.sections.user.edit', compact('user'));
    }
}
