<?php

namespace App\Http\Controllers;

use App\Models\Ship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShipController extends Controller
{
    public function index()
    {
        $ships = Auth::user()->ships()->latest()->get();
        return view('ships.index', compact('ships'));
    }

    public function create()
    {
        return view('ships.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'imo_number' => ['nullable', 'string', 'max:50'],
            'flag' => ['nullable', 'string', 'max:100'],
        ]);

        Auth::user()->ships()->create($request->only('name', 'imo_number', 'flag'));

        return redirect()->route('ships.index')->with('success', 'Ship added successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Ship $ship)
    {
        $this->authorize('update', $ship);
        return view('ships.edit', compact('ship'));
    }

    public function update(Request $request, Ship $ship)
    {
        $this->authorize('update', $ship);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'imo_number' => ['nullable', 'string', 'max:50'],
            'flag' => ['nullable', 'string', 'max:100'],
        ]);

        $ship->update($request->only('name', 'imo_number', 'flag'));

        return redirect()->route('ships.index')->with('success', 'Ship updated successfully.');
    }

    public function destroy(Ship $ship)
    {
        $this->authorize('delete', $ship);
        $ship->delete();
        return redirect()->route('ships.index')->with('success', 'Ship removed.');
    }
}
