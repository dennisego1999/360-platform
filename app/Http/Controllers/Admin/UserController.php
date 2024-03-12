<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Actions\Jetstream\DeleteUser;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function index(Request $request): Response
    {
        $users = User::query()
            ->when($request->input('search'), function ($query) use ($request) {
                $query
                    ->where('first_name', 'like', $request->input('search').'%')
                    ->orWhere('last_name', 'like', $request->input('search').'%');
            })
            ->with(['roles'])
            ->paginate(10);

        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Users/Create', [
            'roles' => Role::all(),
        ]);
    }

    public function store(Request $request, CreateNewUser $createNewUser): RedirectResponse
    {
        // Authorize
        $this->authorize('create', User::class);

        // Create new user
        $createNewUser->create($request->all());

        return redirect()->route('admin.users.index')->with('success', trans('spa.toasts.description.user_created'));
    }

    public function show(User $user): Response
    {
        return Inertia::render('Admin/Users/Show', [
            'user' => $user,
        ]);
    }

    public function edit(User $user): Response
    {
        return Inertia::render('Admin/Users/Edit', [
            'user' => $user->loadMissing(['roles']),
            'roles' => Role::all(),
        ]);
    }

    public function update(
        Request $request,
        UpdateUserProfileInformation $updateUserProfileInformation,
        User $user
    ): RedirectResponse {
        // Authorize
        $this->authorize('update', $user);

        // Update user profile information
        $updateUserProfileInformation->update($user, $request->all());

        return redirect()->route('admin.users.index')->with('success', trans('spa.toasts.description.user_updated'));
    }

    public function destroy(DeleteUser $deleteUserAction, User $user): RedirectResponse
    {
        // Authorize
        $this->authorize('delete', $user);

        // Delete the user
        $deleteUserAction->delete($user);

        return redirect()->back()->with('success', trans('spa.toasts.description.user_deleted'));
    }
}
