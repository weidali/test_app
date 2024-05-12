<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    public const LEVEL_GRADE_1 = [
        'position' => 1,
        'value' => 1,
    ];
    public const LEVEL_GRADE_2 = [
        'position' => 2,
        'value' => 100 * 100,
    ];
    public const LEVEL_GRADE_3 = [
        'position' => 3,
        'value' => 1000 * 100,
    ];
    public const LEVEL_GRADE_4 = [
        'position' => 4,
        'value' => 20000 * 100,
    ];
    public const LEVEL_GRADE_5 = [
        'position' => 5,
        'value' => 50000 * 100,
    ];
    public const LEVEL_GRADE_6 = [
        'position' => 6,
        'value' => 100000 * 100,
    ];
    public const LEVEL_GRADE_7 = [
        'position' => 7,
        'value' => 500000 * 100,
    ];
    public const LEVEL_GRADE_8 = [
        'position' => 8,
        'value' => 1000000 * 100,
    ];

    protected $fillable = [
        'title',
        'position',
    ];
}
