<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\subCategory;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = Food::query();
    
    if ($request->has('sub_category')) {
        $query->where('sub_category_id', $request->sub_category);
    }
    
    $data = $query->get();
    return view('Admin.foods.index', compact('data'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subCategories = subCategory::all();
        return view('Admin.foods.form', compact('subCategories'));
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'name_ckb' => 'required|string|max:255',
            'price' => 'required|numeric',
            'sub_category_id' => 'required|exists:sub_categories,id', // Ensure sub_category_id exists in sub_categories table
        ]);
    


        // Create the food item
        Food::create($validatedData);
    
        return redirect()->route('foods.index')->with('message', 'Food created successfully');
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
        $data = Food::findOrFail($id); // Fetch the sub-category
        $categories = Food::all(); // Fetch all categories
        return view('Admin.foods.form', compact('data', 'categories'));
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'name_ckb' => 'required|string|max:255',
            'price' => 'required|numeric',
            'sub_category_id' => 'required|exists:sub_categories,id', // Ensure sub_category_id exists in sub_categories table
        ]);

        // Update the food item
        $food = Food::findOrFail($id);
        $food->update($validatedData);

        return redirect()->route('foods.index')->with('message', 'Food updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Food::findOrFail($id)->delete(); // Delete the sub-category
        return redirect()->back()->with('message', 'Sub-category deleted successfully');
   
    }
}
