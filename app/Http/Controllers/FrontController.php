<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Table;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    /**
     * Display the home page with menu
     */
    public function index()
    {
        $data = Food::with('sub_category')->where('is_available', 1)->get();
        return view('Frontend.home', compact('data'));
    }

    /**
     * Display menu for QR code scanning (specific table)
     */
    public function menu($tableId = null)
    {
        $data = Food::with('sub_category')->where('is_available', 1)->get();
        $table = $tableId ? Table::find($tableId) : null;
        
        return view('Frontend.home', compact('data', 'table'));
    }
}
