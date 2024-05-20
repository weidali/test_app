<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stack extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'is_main',
    ];

    public static $languages = [
        'PHP',
        'Python',
        'Java',
        'Ruby',
        'Elixir',
        'C_sharp',
        'C_plus_plus',
        'Basic',
        'Delphi',
        'Pascal',
        'JavaScript',
        'TypeScript',
        'Electron',
    ];

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function category()
    {
        return $this->belongsTo(CategoryOfStack::class, 'category_id', 'id');
    }
}
