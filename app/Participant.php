<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
	protected $table = 'participant';
    protected $fillable = [
        'event_id', 
        'participant_id', 
        'name', 
        'email', 
        'phone', 
        'created_at'
    ];
}
