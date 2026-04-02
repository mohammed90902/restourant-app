<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\InvoiceFood;
use App\Models\Table;
use Illuminate\Http\Request;

class ChefController extends Controller
{
    /**
     * Chef Dashboard - Overview of orders
     */
    public function dashboard()
    {
        // Get order statistics
        $pendingCount = InvoiceFood::where('status', '1')->count();
        $preparingCount = InvoiceFood::where('status', '2')->count();
        $readyCount = InvoiceFood::where('status', '3')->count();
        $todayCompleted = InvoiceFood::where('status', '4')
            ->whereDate('updated_at', today())
            ->count();

        // Get recent orders for quick view
        $recentOrders = InvoiceFood::with(['food', 'invoice.table'])
            ->whereIn('status', ['1', '2'])
            ->orderBy('created_at', 'asc')
            ->take(6)
            ->get();

        return view('chef.dashboard', compact(
            'pendingCount', 
            'preparingCount', 
            'readyCount', 
            'todayCompleted',
            'recentOrders'
        ));
    }

    /**
     * Chef Orders - Main order management
     */
    public function orders()
    {
        $data = InvoiceFood::with(['food', 'invoice.table', 'invoice.user'])
            ->whereIn('status', ['1', '2', '3'])
            ->orderByRaw("CASE WHEN status = '1' THEN 1 WHEN status = '2' THEN 2 ELSE 3 END")
            ->orderBy('created_at', 'asc')
            ->get();

        return view('chef.orders', compact('data'));
    }

    /**
     * Update order status
     */
    public function updateOrder(Request $request, $id)
    {
        $item = InvoiceFood::findOrFail($id);
        
        // Chef can only update to: preparing (2) or ready (3)
        $allowedStatuses = ['2', '3'];
        if (!in_array($request->status, $allowedStatuses)) {
            return redirect()->back()->with('error', 'Invalid status');
        }

        $item->update(['status' => $request->status]);

        return redirect()->back()->with('message', 'Order status updated successfully');
    }

    /**
     * View menu (READ-ONLY)
     */
    public function menu()
    {
        $data = Food::with('sub_category')->get();
        return view('chef.menu', compact('data'));
    }

    /**
     * View tables (READ-ONLY - limited info)
     */
    public function tables()
    {
        $data = Table::select('id', 'table_number', 'capacity', 'status')->get();
        return view('chef.tables', compact('data'));
    }
}
