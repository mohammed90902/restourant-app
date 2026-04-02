<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Category::all(); // Fetch all users
        return view('Admin.category.index', compact('data'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.category.form');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_en' => ['required', 'string', 'max:255'], 
            'name_ar' => ['required', 'string', 'max:255'], 
            'name_ckb' => ['required', 'string', 'max:255'], 
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'], 
        ]);
    
        $data = $request->only(['name_en', 'name_ar', 'name_ckb']);
    
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
            $data['image'] = $imagePath;
        }
    
        Category::create($data);
        
        return redirect()->back()->with("message", "Category created successfully");
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {


      

        $data = Category::findOrFail($id);
        return view('Admin.category.form',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $request->validate([
        'name_en' => ['required', 'string', 'max:255'], 
        'name_ar' => ['required', 'string', 'max:255'], 
        'name_ckb' => ['required', 'string', 'max:255'], 
        'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'], 
    ]);

    $category = Category::findOrFail($id); // Retrieve the category instance

    $data = $request->only(['name_en', 'name_ar', 'name_ckb']);

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('categories', 'public');
        $data['image'] = $imagePath;
    }

    $category->update($data); // Call update() on the instance

    return redirect()->back()->with("message", "Category updated successfully");
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Category::findOrFail($id)->delete();
        return redirect()->back()->with("message", "Data deleted successfully");
   
    }
}
