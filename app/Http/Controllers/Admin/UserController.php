<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $data = User::all(); // Fetch all users
        return view('Admin.users.index', compact('data'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.users.form');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|unique:users,email|max:255',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:1,2,3,4', // Admin, Waiter, Chef, Customer
        ]);

        User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);
        
        return redirect()->route('users.index')->with("message", "User created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {   $data = User::findOrFail($id);
        return view('Admin.users.form',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required|in:1,2,3,4', // Admin, Waiter, Chef, Customer
        ]);

        $user = User::findOrFail($id);
        
        $updateData = [
            'email' => $request->email,
            'role' => $request->role,
        ];
        
        // Only update password if provided
        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($request->password);
        }
        
        $user->update($updateData);
        
        return redirect()->route('users.index')->with("message", "User updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       User::findOrFail($id)->delete();
       return redirect()->back()->with("message", "Data deleted successfully");
    }
}
