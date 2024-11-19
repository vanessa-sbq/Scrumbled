<?php

namespace App\Http\Controllers;

use App\Models\Project;
use \Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    /**
     * Display the profile of a user.
     *
     * @return View
     */
    public function index() {
        // Get the authenticated user
        $user = Auth::user();

        $projects = Project::where('product_owner_id', $user->id)
            ->orWhereHas('developers', function ($query) use ($user) {
                $query->where('developer_id', $user->id);
            })
            ->get();

        //TODO: REMOVE
        // dd($user);

        return view('web.sections.profile.index', [
            'user' => $user,
            'projects' => $projects
        ]);

        //TODO:
        // Implement the button to edit profile.
        // Implement profile edit page.
        // Change function/blade files names ?
        // Change routes in web.php.
        // Prevent non authenticated users from connecting to the endpoint...

    }


}
