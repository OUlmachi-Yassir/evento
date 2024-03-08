<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $users = User::all();
        return view('admin',compact('categories','users'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        Category::create([
            'name' => $request->name,
        ]);
        return redirect()->route('admin.dashboard')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        $categories = Category::all();
        return view('admin', compact('categories'));
    }

    public function update(Request $request, Category $category)
    {
        $category->update($request->all());
        return redirect()->route('admin.dashboard')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Category deleted successfully.');
    }
}
