<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserRemoveRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    public function index(): View
    {
        return view('users.index', [
            'users' => User::all(),
        ]);
    }

    public function form(Request $request): View
    {
        $parameters = [
            'roles' => Role::all(),
        ];

        if (null !== $request->route('user')) {
            $parameters['user'] = User::findOrFail($request->user);
        }

        return view('users.form', $parameters);
    }

    public function update(UserUpdateRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = User::findOrFail($request->id);
        $user->fill($request->validated())->save();

        $this->setRoles($user, $request);

        return Redirect::route('users.index')->with('status', 'user-updated');
    }

    public function remove(UserRemoveRequest $request): RedirectResponse
    {
        $user = User::findOrFail($request->user);
        $user->delete();

        return Redirect::route('users.index')->with('status', 'user-deleted');
    }

    public function create(UserCreateRequest $request): RedirectResponse
    {
        $user = User::create($request->validated());

        $this->setRoles($user, $request);

        return Redirect::route('users.index')->with('status', 'user-created');
    }

    private function setRoles(User $user, FormRequest $request): void
    {
        $roles = Role::whereIn('id', $request->validated('roles') ?? [])->get();
        $user->syncRoles($roles->pluck('name'));
    }
}
