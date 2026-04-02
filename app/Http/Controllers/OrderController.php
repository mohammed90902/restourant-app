<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Food;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Chef's view: All pending and preparing items
        $data = \App\Models\InvoiceFood::with(['food', 'invoice.table'])
            ->whereIn('status', ['1', '2']) // 1: pending, 2: preparing
            ->orderBy('created_at', 'asc')
            ->get();
            
        return view('Admin.orders.index', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $item = \App\Models\InvoiceFood::findOrFail($id);
        $item->update(['status' => $request->status]);

        return redirect()->back()->with('message', 'Order updated');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'food_items' => 'required|array',
            'food_items.*' => 'exists:food,id',
            'table_id' => 'nullable|exists:tables,id',
        ]);

        $user = auth()->user();
        
        // Use provided table_id (from QR code) or assign first available table
        if (!empty($validated['table_id'])) {
            $table = \App\Models\Table::find($validated['table_id']);
        } else {
            $table = \App\Models\Table::first();
        }
        
        if (!$table) {
            return response()->json(['success' => false, 'message' => 'No tables available'], 400);
        }

        $invoice = \App\Models\Invoice::create([
            'table_id' => $table->id,
            'status' => 0, // 0: pending payment
            'total_price' => 0,
            'user_id' => $user->id
        ]);

        $totalPrice = 0;
        foreach ($validated['food_items'] as $foodId) {
            $food = \App\Models\Food::find($foodId);
            \App\Models\InvoiceFood::create([
                'food_id' => $food->id,
                'invoice_id' => $invoice->id,
                'price' => $food->price,
                'quantity' => 1,
                'status' => '1', // 1: pending (chef view)
                'user_id' => $user->id
            ]);
            $totalPrice += $food->price;
        }

        $invoice->update(['total_price' => $totalPrice]);
        
        // Update table status to occupied
        $table->update(['status' => 'occupied']);

        return response()->json([
            'success' => true,
            'invoice_id' => $invoice->id,
            'table_id' => $table->table_number
        ]);
    }

    public function success()
    {
        return view('Frontend.order-success');
    }
}