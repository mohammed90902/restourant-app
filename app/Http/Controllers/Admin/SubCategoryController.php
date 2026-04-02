<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Food;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = SubCategory::all(); // Fetch all sub-categories
        return view('Admin.sub-Category.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all(); // Fetch all categories
        return view('Admin.sub-Category.form', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name_en' => ['required', 'string', 'max:255'],
            'name_ar' => ['required', 'string', 'max:255'],
            'name_ckb' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $data = $request->only(['category_id', 'name_en', 'name_ar', 'name_ckb']);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('sub_category', 'public');
            $data['image'] = $imagePath;
        }

        SubCategory::create($data); // Create the sub-category
        return redirect()->back()->with('message', 'Sub-category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = SubCategory::with('category')->findOrFail($id);
        return view('Admin.sub-Category.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = SubCategory::findOrFail($id); // Fetch the sub-category
        $categories = Category::all(); // Fetch all categories
        return view('Admin.sub-Category.form', compact('data', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name_en' => ['required', 'string', 'max:255'],
            'name_ar' => ['required', 'string', 'max:255'],
            'name_ckb' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $subCategory = SubCategory::findOrFail($id); // Fetch the sub-category
        $data = $request->only(['category_id', 'name_en', 'name_ar', 'name_ckb']);

        if ($request->hasFile('image')) {   
            $imagePath = $request->file('image')->store('sub_category', 'public');
            $data['image'] = $imagePath;
        }

        $subCategory->update($data); // Update the sub-category
        return redirect()->back()->with('message', 'Sub-category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        SubCategory::findOrFail($id)->delete(); // Delete the sub-category
        return redirect()->back()->with('message', 'Sub-category deleted successfully');
    }
}