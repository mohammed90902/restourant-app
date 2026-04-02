<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Table::all(); // Fetch all tables
        return view('Admin.tables.index', compact('data'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.tables.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'table_number' => 'required|unique:tables,table_number', // Ensure table number is unique
        ]);

        // Create the table
        Table::create($validatedData);

        return redirect()->route('tables.index')->with('message', 'Table created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Table::all(); // Fetch all tables
        return view('server.server', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Table::findOrFail($id); // Fetch the table
        return view('Admin.tables.form', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'table_number' => 'required|unique:tables,table_number,' . $id, // Ensure table number is unique, excluding the current record
        ]);

        // Update the table
        $table = Table::findOrFail($id);
        $table->update($validatedData);

        return redirect()->route('tables.index')->with('message', 'Table updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Table::findOrFail($id)->delete(); // Delete the table
        return redirect()->back()->with('message', 'Table deleted successfully');
    }
}