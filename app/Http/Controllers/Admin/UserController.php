<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('is_admin', false)->withCount('ships')->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'email'        => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'     => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name'         => $request->name,
            'company_name' => $request->company_name,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'is_admin'     => false,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User account created successfully.');
    }
}
