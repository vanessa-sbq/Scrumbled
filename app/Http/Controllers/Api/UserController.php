<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AuthenticatedUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {
    public function search(Request $request) {
        if ($request->has('status') && Auth::guard("admin")->check()) { // Escalate Privileges only if Admin is logged in.
            return $this->adminSearch($request);
        }

        $search = $request->input('search');

        $users = AuthenticatedUser::query()
            ->where('username', 'like', "%{$search}%")
            ->orWhere('full_name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->get();

        $v = view('web.sections.profile.components._user', ['users' => $users])->render();

        return response()->json($v);
    }

    public function adminSearch(Request $request) {
        $search = $request->input('search');
        $status = $request->input('status');
        $users = null;
        if ($status === 'ANY') {
            $users = AuthenticatedUser::query()
            ->where('username', 'like', "%{$search}%")
            ->orWhere('full_name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->get();
        } else {
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
        }

        $v = view('admin.components._user', ['users' => $users])->render();

        return response()->json($v);
    }
}
