<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::get();

        foreach ($users as $user) {
            $user->actions = view('admin.users.partials.users-actions')->with('user', $user)->render();
        }

        return view('admin.users.users', [
            'title' => 'Потребители',
            'users' => $users,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return array|string
     * @throws \Throwable
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', ['user' => $user])->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param User                     $user
     * @param \Illuminate\Http\Request $request
     * @param UserRequest              $userRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(User $user, Request $request, UserRequest $userRequest)
    {
        $user->name  = $request->get('name');
        $user->email = $request->get('email');

        if ($request->get('password')) {
            $user->password = bcrypt($request->get('name'));
        }

        $user->first_name = $request->get('first_name') ?? null;
        $user->last_name  = $request->get('last_name') ?? null;
        $user->sex        = $request->get('sex') ?? null;

        $user->save();

        return response()->json([
            'message' => 'Потребителят: <strong>' . $user->name . '</strong><br>' .
                         'Име: <strong>' . $user->full_name . '</strong>' .
                         '<br> беше успешно редактиран.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return void
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $user->delete();
    }
}
