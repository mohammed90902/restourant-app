<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Reservation::all();
        return view('Admin.reservations.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tables = Table::all();
        return view('Admin.reservations.form', compact('tables'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'chair' => 'required|string|max:255',
            'hour' => 'required|date_format:H:i',
            'phone_number' => 'required|string|max:15',
            'table_id' => 'required|exists:tables,id',
        ]);
        
        // Create the reservation
        Reservation::create($validatedData);
    
        return redirect()->route('reservations.index')->with('message', 'Reservation created successfully');
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
    {
        $item = Reservation::findOrFail($id);
        $tables = Table::all();
        return view('Admin.reservations.form', compact('item', 'tables'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'chair' => 'required|string|max:255',
            'hour' => 'required|date_format:H:i',
            'phone_number' => 'required|string|max:15',
            'table_id' => 'required|exists:tables,id',
        ]);

        // Update the reservation
        $reservation = Reservation::findOrFail($id);
        $reservation->update($validatedData);

        return redirect()->route('reservations.index')->with('message', 'Reservation updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Reservation::findOrFail($id)->delete();
        return redirect()->back()->with('message', 'Reservation deleted successfully');
    }
}
