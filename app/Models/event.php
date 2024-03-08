<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class event extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        'description',
        'date',
        'lieu',
        'places_disponibles',
        'id_categorie',
    ];

    public function categorie() {
        return $this->belongsTo(Category::class, 'id_categorie');
    }
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'id_evenement', 'id');
    }
}
