<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Book extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
        'created_at', 
        'updated_at',
    ];

    public function authors(){
        return $this->belongsToMany(Author::class);
    }

    public function genres(){
        return $this->belongsToMany(Genre::class);
    }
}
