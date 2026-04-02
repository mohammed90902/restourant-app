<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Invoice;
use App\Models\InvoiceFood;
use App\Models\Table;
use Illuminate\Http\Request;

class WaiterController extends Controller
{
    /**
     * Waiter Dashboard - Overview
     */
    public function dashboard()
    {
        // Get statistics
        $readyToServe = InvoiceFood::where('status', '3')->count();
        $activeOrders = InvoiceFood::whereIn('status', ['1', '2', '3'])->count();
        $tablesOccupied = Table::where('status', 'occupied')->count();
        $totalTables = Table::count();
        $todayServed = InvoiceFood::where('status', '4')
            ->whereDate('updated_at', today())
            ->count();

        // Get ready orders for quick view
        $readyOrders = InvoiceFood::with(['food', 'invoice.table'])
            ->where('status', '3')
            ->orderBy('updated_at', 'asc')
            ->take(6)
            ->get();

        return view('waiter.dashboard', compact(
            'readyToServe',
            'activeOrders',
            'tablesOccupied',
            'totalTables',
            'todayServed',
            'readyOrders'
        ));
    }

    /**
     * View all orders
     */
    public function orders()
    {
        $data = InvoiceFood::with(['food', 'invoice.table', 'invoice.user'])
            ->whereIn('status', ['1', '2', '3', '4'])
            ->orderByRaw("CASE WHEN status = '3' THEN 1 WHEN status = '2' THEN 2 WHEN status = '1' THEN 3 ELSE 4 END")
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('waiter.orders', compact('data'));
    }

    /**
     * Update order status (deliver)
     */
    public function updateOrder(Request $request, $id)
    {
        $item = InvoiceFood::findOrFail($id);
        
        // Waiter can mark as delivered (4)
        if ($request->status == '4') {
            $item->update(['status' => '4']);
        }

        return redirect()->back()->with('message', 'Order delivered successfully');
    }

    /**
     * View tables
     */
    public function tables()
    {
        $data = Table::withCount(['invoices' => function($q) {
            $q->whereHas('items', function($q2) {
                $q2->whereIn('status', ['1', '2', '3']);
            });
        }])->get();

        return view('waiter.tables', compact('data'));
    }

    /**
     * Take new order form
     */
    public function takeOrder($tableId = null)
    {
        $tables = Table::all();
        $foods = Food::with('sub_category')->where('is_available', 1)->get();
        $selectedTable = $tableId ? Table::find($tableId) : null;

        return view('waiter.take-order', compact('tables', 'foods', 'selectedTable'));
    }

    /**
     * Store new order
     */
    public function storeOrder(Request $request)
    {
        $validated = $request->validate([
            'table_id' => 'required|exists:tables,id',
            'items' => 'required|array',
            'items.*.food_id' => 'required|exists:food,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.notes' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();

        // Create invoice
        $invoice = Invoice::create([
            'table_id' => $validated['table_id'],
            'status' => 0,
            'total_price' => 0,
            'user_id' => $user->id
        ]);

        $totalPrice = 0;
        foreach ($validated['items'] as $item) {
            $food = Food::find($item['food_id']);
            InvoiceFood::create([
                'food_id' => $food->id,
                'invoice_id' => $invoice->id,
                'price' => $food->price,
                'quantity' => $item['quantity'],
                'notes' => $item['notes'] ?? null,
                'status' => '1',
                'user_id' => $user->id
            ]);
            $totalPrice += ($food->price * $item['quantity']);
        }

        $invoice->update(['total_price' => $totalPrice]);

        // Update table status
        Table::where('id', $validated['table_id'])->update(['status' => 'occupied']);

        return redirect()->route('waiter.orders')->with('message', 'Order placed successfully!');
    }
}
