<?php

namespace App\Http\Controllers;

use App\Models\AuthenticatedUser;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function index()
    {
        $users = AuthenticatedUser::paginate(10);
        return view('web.sections.profile.index', compact('users'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $users = AuthenticatedUser::query()
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('username', 'like', "%{$search}%")
                        ->orWhere('full_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->paginate(10);

        return view('web.sections.profile.index', compact('users'));
    }

    /**
     * Display the profile of a user.
     *
     * @return View
     */
    public function getProfile($username)
    {

        $profileOwner = AuthenticatedUser::where('username', $username)->get();

        if ($profileOwner->isEmpty()) {
            abort(404);
        }

        // Get the owner of the current profile.
        $profileOwner = $profileOwner->first();
        $profileOwnerId = $profileOwner->id;

        // Get the authenticated user.
        $user = Auth::user();

        $projects = Project::where('product_owner_id', $profileOwnerId)
            ->orWhereHas('developers', function ($query) use ($profileOwnerId) {
                $query->where('developer_id', $profileOwnerId);
            })
            ->get();

        $availableProjects = $projects->filter(function ($project) use ($user, $profileOwner) {
            return $project->is_public;
        });

        if (Auth::check()) {
            $availableProjects = $projects->filter(function ($project) use ($user, $profileOwner) {
                return $project->is_public || $user->username === $profileOwner->username;
            });
        }

        return view('web.sections.profile.show', [
            'user' => $user,
            'profileOwner' => $profileOwner,
            'projects' => $availableProjects
        ]);
    }

    public function showProfileSettings($username)
    {
        $profileOwner = AuthenticatedUser::where('username', $username)->get();

        if ($profileOwner->isEmpty()) {
            abort(404);
        }

        if (Auth::check() && Auth::user()->username === $username) {
            return view('web.sections.profile.settings', ['user' => Auth::user()]);
        }

        abort(403);
    }

    public function updatePicture(Request $request)
    {
        if (!(Auth::check() && Auth::user()->id !== $request->id)) {
            abort(403);
        }

        // Get the authenticated user
        $user = Auth::user();

        $request->validate([
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle the file upload
        if (!$request->hasFile('picture')) {
            abort(404);
        }

        $picturePath = $request->file('picture')->store('images/users', 'public');
        $user->update(['picture' => $picturePath]);

        session()->flash('edited_profile', true);

        // Redirect to the login page with a success message
        return redirect()->route('profile.settings', $user->username)->with('success', 'Profile edited successfully');
    }
}
