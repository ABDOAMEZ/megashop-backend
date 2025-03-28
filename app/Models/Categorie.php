<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'parent_id',
        'categorie_icon_url'
    ];

    protected $table = 'categories';
}
