<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{   
    // Haal alle categorieën op
    public function index()
    {   // Haal alle categorieën op, gesorteerd op nieuwste eerst
        $categories = Category::latest()->get();

        return view('categories.index', compact('categories'));
    }


    // Voeg een nieuwe categorie toe
    public function store(Request $request)
    {   // Valideer de input van het formulier
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);
        // Maak een nieuwe categorie aan met de gevalideerde data
        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->route('categories.index');  
    }
    // Verwijder een categorie, maar alleen als er geen uitgaven aan gekoppeld zijn


    public function destroy(Category $category)
{   // Controleer of er nog uitgaven aan deze categorie gekoppeld zijn
    if ($category->expenses()->count() > 0) {
        return redirect()->route('categories.index');
    }

    $category->delete();

    return redirect()->route('categories.index');
}
}