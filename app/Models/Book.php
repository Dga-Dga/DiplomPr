<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Book extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'author', 'price', 'image', 'genre'];

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

public function isFavorited(): bool
{
    return Auth::check() && $this->favoritedBy()->where('user_id', Auth::id())->exists();
}

}
