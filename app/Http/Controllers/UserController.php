<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para acceder a esta página');
        }

        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para acceder a esta página');
        }

        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:1',
            'password' => 'required|string|min:8',
            'avatar' => 'required|in:avatar1.png,avatar2.png,avatar3.png',
        ]);

        User::create([
            'name' => $request->name,
            'age' => $request->age,
            'password' => Hash::make($request->password),
            'avatar' => $request->avatar,
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente');
    }

    public function edit(User $user)
    {
        if (!auth()->user()->isAdmin() && auth()->id() !== $user->id) {
            abort(403, 'No tienes permisos para acceder a esta página');
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (!auth()->user()->isAdmin() && auth()->id() !== $user->id) {
            abort(403, 'No tienes permisos para acceder a esta página');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:1',
            'password' => 'nullable|string|min:8',
            'avatar' => 'required|in:avatar1.png,avatar2.png,avatar3.png',
        ]);

        $user->update([
            'name' => $request->name,
            'age' => $request->age,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'avatar' => $request->avatar,
        ]);

        return redirect()->route('users.profile', $user->id)->with('success', 'Perfil actualizado exitosamente');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function removeFriend(User $user, Request $request)
    {
        $friend = User::findOrFail($request->friend_id);
        $user->friends()->detach($friend->id);
        return redirect()->back()->with('success', 'Amistad eliminada exitosamente');
    }

    public function profile(Request $request, User $user)
    {
        $friends = $user->friends;
        $potentialFriends = User::where('id', '!=', $user->id)
            ->whereNotIn('id', $user->friends->pluck('id'))
            ->get();
        return view('users.profile', compact('user', 'friends', 'potentialFriends'));
    }

    public function addFriend(Request $request, User $user)
    {
        $request->validate([
            'friend_id' => 'required|exists:users,id',
        ]);

        $friend = User::findOrFail($request->friend_id);

        if (!$user->isFriendWith($friend)) {
            $user->friends()->attach($friend->id);
            return redirect()->route('users.profile', $user->id)->with('success', 'Amigo añadido exitosamente');
        }

        return back()->with('error', 'Ya eres amigo de esta persona');
    }
}
