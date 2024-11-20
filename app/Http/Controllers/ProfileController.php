<?php

namespace App\Http\Controllers;

use App\Models\AuthenticatedUser;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    /**
     * Display the profile of a user.
     *
     * @return View
     */
    public function index() {
        //TODO:
        // Implement the button to edit profile.
        // Implement profile edit page.
        // Change function/blade files names ?
        // Change routes in web.php.
        // Prevent non authenticated users from connecting to the endpoint...


        //FIXME:
        // Password needs to use bcrypt instead of hash
        // As we declared in the ER and EBD, a user
        // cannot have a null username
        // cannot have a null full_name
        // cannot have a null email
        // This not only affects some of the pages but also the edit profile...
        // Photos are being saved to /storage/app/public/img/users...
    }

    public function getProfile($username) {

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

        return view('web.sections.profile.index', [
            'user' => $user,
            'profileOwner' => $profileOwner,
            'projects' => $availableProjects
        ]);
    }

    public function showEditProfileUI($username) {
        $profileOwner = AuthenticatedUser::where('username', $username)->get();

        if ($profileOwner->isEmpty()) {
            abort(404);
        }

        if (Auth::check() && Auth::user()->username === $username) {
            return view('web.sections.profile.edit', ['user' => Auth::user()]);
        }

        abort(403);
    }

    public function editProfile(Request $request) {

        if (!(Auth::check() && Auth::user()->id !== $request->id)) {
            abort(403);
        }

        // Get the authenticated user
        $user = Auth::user();

        // Validate the request data
        $request->validate([
            'username' => 'required|string|max:250|alpha_dash|unique:authenticated_user,username,' . $user->id,
            'email' => 'required|email|max:250|unique:authenticated_user,email,' . $user->id,
            'password' => 'required',
            'full_name' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Collect the validated data
        $data = $request->only('username', 'email', 'full_name', 'bio');

        if (!Hash::check($request->password, Auth::user()->password)) {
            return redirect()->back()->withErrors(['password' => 'The provided password is incorrect.']);
        }

        $data['password'] = Hash::make($request->password);

        // Handle the file upload
        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('img/users', 'public');
            $data['picture'] = $picturePath;
        }

        // Edit the user's profile
        $user->update($data);


        // Redirect to the login page with a success message
        return redirect()->route('show.profile', $user->username)->with('success', 'Profile edited successfully');
    }


}
