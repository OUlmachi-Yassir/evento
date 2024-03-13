<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_evenement',
        'id_utilisateur',
        'event_id',
        'user_id',
        'nombre_places',
        'date_reservation',
        'statut',
    ];

    // Define the relationship with the Event model
    public function event()
    {
        return $this->belongsTo(Event::class, 'id_evenement');
    }

    // Define the relationship with the User model
    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_utilisateur', 'id');
    }
    
}
