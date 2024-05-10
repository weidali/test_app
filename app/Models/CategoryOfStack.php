<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryOfStack extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    public function stacks()
    {
        return $this->hasMany(Stack::class, 'category_id', 'id');
    }
}
