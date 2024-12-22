<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AuthenticatedUser;

class ProfileController extends Controller
{
    public function changeProfileVisibility(Request $request)
    {
        $profile = AuthenticatedUser::where('username', $request->oldUsername)->firstOrFail();

        if (Auth::user()->username !== $profile->username) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized.'], 403);
        }

        $profile->is_public = !$profile->is_public;
        $profile->save();

        return response()->json(['status' => 'success']);
    }

    public function deleteProfile(Request $request)
    {
        $profile = AuthenticatedUser::where('username', $request->username)->firstOrFail();

        if (Auth::user()->username !== $profile->username) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized.'], 403);
        }

        $profile->delete();

        return response()->json(['status' => 'success', 'redirect' => '/profiles']);
    }

    public function changeUsername(Request $request)
    {
        $profile = AuthenticatedUser::where('username', $request->oldUsername)->firstOrFail();

        if (Auth::user()->username !== $profile->username) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized.'], 403);
        }

        $request->validate(['newUsername' => 'required|string|max:255|unique:authenticated_user,username,' . $profile->id]);

        $profile->username = $request->newUsername;
        $profile->save();

        return response()->json(['status' => 'success']);
    }

    public function changeEmail(Request $request)
    {
        $profile = AuthenticatedUser::where('username', $request->username)->firstOrFail();

        if (Auth::user()->username !== $profile->username) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized.'], 403);
        }

        $request->validate(['email' => 'required|email|max:255|unique:authenticated_user,email,' . $profile->id]);

        $profile->email = $request->email;
        $profile->save();

        return response()->json(['status' => 'success']);
    }

    public function changeFullName(Request $request)
    {
        $profile = AuthenticatedUser::where('username', $request->username)->firstOrFail();

        if (Auth::user()->username !== $profile->username) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized.'], 403);
        }

        $request->validate(['full_name' => 'required|string|max:255']);

        $profile->full_name = $request->full_name;
        $profile->save();

        return response()->json(['status' => 'success']);
    }

    public function changeBio(Request $request)
    {
        $profile = AuthenticatedUser::where('username', $request->username)->firstOrFail();

        if (Auth::user()->username !== $profile->username) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized.'], 403);
        }

        $request->validate(['bio' => 'nullable|string|max:5000']);

        $profile->bio = $request->bio;
        $profile->save();

        return response()->json(['status' => 'success']);
    }

    public function changeProfilePicture(Request $request)
    {
        $profile = AuthenticatedUser::where('username', $request->username)->firstOrFail();

        if (Auth::user()->username !== $profile->username) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized.'], 403);
        }

        $request->validate(['profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048']);

        $path = $request->file('profile_picture')->store('images/users', 'public');
        $profile->picture = $path;
        $profile->save();

        return response()->json(['status' => 'success', 'picturePath' => $path]);
    }
}
