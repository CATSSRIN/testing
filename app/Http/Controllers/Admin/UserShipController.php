<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserShipController extends Controller
{
    public function create(User $user)
    {
        return view('admin.users.ships.create', compact('user'));
    }

    public function store(Request $request, User $user)
    {
        $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'imo_number' => ['nullable', 'string', 'max:50'],
            'flag'       => ['nullable', 'string', 'max:100'],
        ]);

        $user->ships()->create($request->only('name', 'imo_number', 'flag'));

        return redirect()->route('admin.users.index')->with('success', 'Ship added successfully.');
    }
}
