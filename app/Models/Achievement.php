<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    protected $table = 'achievements';

    protected $primaryKey = 'id';

    protected $fillable = [
        'supervisor_name',
        'achievement_name',
        'day',
        'date',
        'semester',
        'section',
        'section_type',
        'proof',
        'attendees_number',
        'target_group',
    ];
}
