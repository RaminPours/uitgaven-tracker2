<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    // Hier komen de methodes voor het beheren van uitgaven (expenses)
    public function index(Request $request)
    {   // Haal alle categorieën op voor de filter en dropdowns
        $categories = Category::all();
        // Haal de uitgaven op, eventueel gefilterd op maand
        $expenses = Expense::with('category')
            ->when($request->month, function ($query) use ($request) {
                $query->whereMonth('date', $request->month);
            })
            ->latest()
            ->get();
        // Bereken het totaal van alle uitgaven
        $totalAmount = $expenses->sum('amount');
        
        // Bereken het totaal per categorie
        $totalsPerCategory = Category::withSum('expenses', 'amount')->get();
        // Geef de view terug met de uitgaven, categorieën en totalen
        return view('expenses.index', compact(
            'expenses',
            'categories',
            'totalAmount',
            'totalsPerCategory'
        ));
    }

    // Hier komen de methodes voor het toevoegen en verwijderen van uitgaven (expenses)
    public function store(Request $request)
    {   // Valideer de input van het formulier  
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
        ]);
        // Maak een nieuwe uitgave aan met de gevalideerde data  
        Expense::create($request->only([
            'title',
            'amount',
            'date',
            'category_id',
        ]));
        // Redirect terug naar de uitgavenpagina
        return redirect()->route('expenses.index');
    }

    // Hier komen de methodes voor het verwijderen van uitgaven (expenses)
    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('expenses.index');
    }
}