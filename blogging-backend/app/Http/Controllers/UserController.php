<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'bio' => 'nullable|string',
            'password' => 'required|string|min:8',
        ]);
    
        $validated['password'] = bcrypt($validated['password']);
    
        $user = User::create($validated);
        return response()->json($user, 201);
    }
    
    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $validated = $request->validate([
        'name' => 'sometimes|string|max:255',
        'email' => 'sometimes|email|unique:users,email,' . $id,
        'bio' => 'nullable|string',
        'password' => 'nullable|string|min:8',
    ]);

    if (isset($validated['password'])) {
        $validated['password'] = bcrypt($validated['password']);
    }

    $user->update($validated);

    return response()->json($user);
}

public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return response()->json(['message' => 'User deleted successfully']);
}
}
