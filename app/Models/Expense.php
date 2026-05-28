<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{   // Vul de $fillable property in zodat we mass assignment kunnen gebruiken in de controller
    protected $fillable = [
        'title',
        'amount',
        'date',
        'category_id',
    ];
    // Definieer de relatie met de Category model
    public function category()
    {   // Een uitgave behoort tot één categorie
        return $this->belongsTo(Category::class);
    }

}