<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{   // Vul de $fillable property in zodat we mass assignment kunnen gebruiken in de controller
    protected $fillable = ['name'];
    // Definieer de relatie met de Expense model
    public function expenses()
    {   // Een categorie kan meerdere uitgaven hebben
        return $this->hasMany(Expense::class);
    }
}