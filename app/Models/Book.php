<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'release_date' => 'datetime:M d, Y',
        'authors' => 'array'
    ];

    protected $visible = ['name', 'isbn', 'authors', 'country', 'number_of_pages', 'publisher', 'release_date'];
}
