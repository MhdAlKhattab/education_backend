<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visiting extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'supervisor_name',
        'date',
        'form',
    ];
}
