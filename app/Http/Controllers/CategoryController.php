<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', ['categories' => $categories]);
    }

    public function create()
    {
         return view('categories.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'description'        => 'required|string|max:255',
        ]);

        Category::create($validated);

        return back()->with('success', 'Nouvelle catégorie enregistré');
    }
}
