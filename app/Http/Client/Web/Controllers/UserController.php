<?php

namespace App\Http\Client\Web\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\User;


class UserController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        return view('client.my.index', [
            'user' => $user
        ]);
    }
    public function edit()
    {
        $user = auth()->user();
        return view('client.my.edit', [
            'user' => $user
        ]);
    }
    public function update(ProfileRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->only(
            'name',
            'email',
            'phone',
            'password'
        ));
        $user->mediaManage($request);
        return redirect()->route('my');
    }
}
