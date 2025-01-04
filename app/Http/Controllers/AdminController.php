<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['name', 'email']);
        $users = User::query()
            ->when($filters['name'] ?? false, function ($query, $name) {
                $query->where('name', 'like', "%$name%");
            })
            ->when($filters['email'] ?? false, function ($query, $email) {
                $query->where('email', 'like', "%$email%");
            })
            ->paginate(10);        
            
        return view('admin.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::inRandomOrder()->first();

        return view('admin.create', compact('user'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create($validated);


        return redirect()->route('admin.index')->with('success', 'Admin created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.show', compact('user'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit', compact('user'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // $user->update([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => $request->password ? bcrypt($request->password) : $user->password,
        // ]);
        $user->update($validated);


        return redirect()->route('admin.index')->with('success', 'Admin updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();        
        return redirect()->route('admin.index')->with('success', 'Admin deleted successfully.');
    }
}
