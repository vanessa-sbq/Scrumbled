<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AuthenticatedUser;

class ProfileController extends Controller
{
    public function changeProfileVisibility(Request $request)
    {
        $profile = AuthenticatedUser::where('username', $request->username)->firstOrFail();

        if (Auth::user()->username !== $profile->username) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized.'], 403);
        }

        $profile->update(['is_public' => !$profile->is_public]);
        return response()->json(['status' => 'success', 'message' => 'Visibility change successful']);
    }

    public function deleteProfile(Request $request)
    {
        $profile = AuthenticatedUser::where('username', $request->username)->firstOrFail();

        $userProjectsWherePO = Project::where('product_owner_id', $profile->id)->get();

        if (Auth::user()->username !== $profile->username) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized.'], 403);
        }

        $publicProjects = [];
        $privateProjects = [];
        foreach ($userProjectsWherePO as $userProjectWherePO) {
            if ($userProjectWherePO['is_public']) {
                $publicProjects[] = $userProjectWherePO;
            } else {
                $privateProjects[] = $userProjectWherePO;
            }
        }

        foreach ($privateProjects as $privateProject) {
            $privateProject->delete();
        }

        foreach ($publicProjects as $publicProject) {
            $publicProject->update(['is_archived' => true]);
        }

        $profile->delete();

        return response()->json(['status' => 'success', 'redirect' => '/']);
    }

    public function changeUsername(Request $request)
    {
        $newUsername = $request->newUsername;
        $oldUsername = $request->oldUsername;

        $profile = AuthenticatedUser::where('username', $oldUsername)->firstOrFail();

        if (strlen($newUsername) === 0) {
            return response()->json(['status' => 'error', 'message' => 'Fill username field.'], 400);
        }

        if (Auth::user()->username !== $profile->username) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized.'], 403);
        }

        $profile->update(['username' => $newUsername]);
        return response()->json(['status' => 'success', 'message' => 'Username changed successfully', 'redirect' => route('profile.settings', $newUsername)], 301);
    }

    public function changeEmail(Request $request)
    {
        $email = $request->email;
        $profile = AuthenticatedUser::where('username', $request->username)->firstOrFail();

        if (strlen($email) === 0) {
            return response()->json(['status' => 'error', 'message' => 'Fill email field.'], 400);
        }

        if (Auth::user()->username !== $profile->username) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized.'], 403);
        }

        $profile->update(['email' => $email]);
        return response()->json(['status' => 'success', 'message' => 'Email changed successfully', 'redirect' => route('profile.settings', $profile->username)], 301);
    }

    public function changeFullName(Request $request)
    {
        $fullName = $request->full_name;
        $profile = AuthenticatedUser::where('username', $request->username)->firstOrFail();

        if (strlen($fullName) === 0) {
            return response()->json(['status' => 'error', 'message' => 'Fill full name field.'], 400);
        }

        if (Auth::user()->username !== $profile->username) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized.'], 403);
        }

        $profile->update(['full_name' => $fullName]);
        return response()->json(['status' => 'success', 'message' => 'Full name changed successfully', 'redirect' => route('profile.settings', $profile->username)], 301);
    }

    public function changeBio(Request $request)
    {
        $bio = $request->bio;
        $profile = AuthenticatedUser::where('username', $request->username)->firstOrFail();

        if (strlen($bio) > 5000) {
            return response()->json(['status' => 'error', 'message' => 'Bio cant be bigger that 5000 characters.'], 400);
        }

        if (Auth::user()->username !== $profile->username) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized.'], 403);
        }

        $profile->update(['bio' => $bio]);
        return response()->json(['status' => 'success', 'message' => 'Bio changed successfully', 'redirect' => route('profile.settings', $profile->username)], 301);
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
