<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    public const LEVEL_GRADE_1 = [
        'position' => 1,
        'value' => 100,
    ];
    public const LEVEL_GRADE_2 = [
        'position' => 2,
        'value' => 1000,
    ];
    public const LEVEL_GRADE_3 = [
        'position' => 3,
        'value' => 10000,
    ];
    public const LEVEL_GRADE_4 = [
        'position' => 4,
        'value' => 100000,
    ];
    public const LEVEL_GRADE_5 = [
        'position' => 5,
        'value' => 1000000,
    ];
    public const LEVEL_GRADE_6 = [
        'position' => 6,
        'value' => 10000000,
    ];
    public const LEVEL_GRADE_7 = [
        'position' => 7,
        'value' => 100000000,
    ];
    public const LEVEL_GRADE_8 = [
        'position' => 8,
        'value' => 100000000,
    ];

    protected $fillable = [
        'title',
        'position',
    ];
}
