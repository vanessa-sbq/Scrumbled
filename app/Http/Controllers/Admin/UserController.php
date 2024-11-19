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
        return view('admin.sections.user.show', compact('user'));
    }

    public function edit($username)
    {
        $user = AuthenticatedUser::where('username', $username)->firstOrFail();
        return view('admin.sections.user.edit', compact('user'));
    }
}
