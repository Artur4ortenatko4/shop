<?php

namespace App\Http\Admin\Controllers;

use App\Actions\Admin\Users\FilterAction;
use App\Actions\Admin\Users\SortAction;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Admin\Requests\UserRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index(Request $request, FilterAction $filterAction, SortAction $sortAction)
    {
        $filters = $request->all();
        $query = $filterAction->run($filters);
        $query = $sortAction->run($request, $query);
        $users = $query->paginate(10);
        $roles = $request->input('role', []);
        return view('admin.users.index', compact('users', 'roles'));
    }


    public function create()
    {
        return view('admin.users.create');
    }

    public function store(UserRequest $request)
    {
        $user = User::create(array_merge(
            $request->only([
                'name',
                'email',
                'role',
            ]),
            ['password' => Hash::make($request->input('password'))]
        ));
        $user->mediaManage($request);
        return redirect()->route('admin.users.index');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function edit()
    {
    }
    public function update(UserRequest $request, $id)
    {
        /** @var User $user */
        $user = User::findOrFail($id);
        $user->update(
            $request->only(
                'name',
                'email',
                'role',
            )
        );
        $user->mediaManage($request);
        return redirect()->route('admin.users.index');
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users.index');
    }
    public function showProfile()
    {
        $user = Auth::user();
        return view('admin.profile.index', compact('user'));
    }
    public function editProfile()
    {
        $user = Auth::user();
        return view('admin.profile.edit', compact('user'));
    }
    public function updateProfile(UserRequest $request, $id)
    {
        $user = User::find($id);
        $user->update(
            $request->only(
                'name',
                'email',
                'password',
            )
        );
        $user->mediaManage($request);
        return redirect()->route('admin.profile');
    }
    // public function testPolicy(User $user)
    // {

    //     if (Gate::allows('view', $user)) {
    //         // Користувач з роллю "seller" має доступ
    //         return view('user.leyouts.index', compact('user'));
    //     } else {
    //         // Інші користувачі не мають доступу
    //         abort(403);
    //     }
    // }
}
