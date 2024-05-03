<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'username', 'chat_id', 'taps', 'multiplier', 'balance', 'score',
    ];

    // protected $appends = [
    //     'balance',
    //     'score',
    // ];

    // public function getBalanceAttribute()
    // {
    //     return $this->balance;
    // }

    // public function getScoreAttribute()
    // {
    //     return $this->score;
    // }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($player) {
            if ($player->isDirty('taps')) {
                /**
                 * $player = new Player;
                 * $player->username = 'username';
                 * $player->chat_id = '123456';
                 * $player->taps = 100;
                 * $player->save(['multiplier' => 3]);
                 */
                $default_multiplier = 1;
                $multiplier = request()->input('multiplier', $default_multiplier);

                $player->balance = $player->taps * $multiplier;
                $player->score = $player->taps * $multiplier;
            }
        });
    }

    public static function isAdmin($chatId)
    {
        $adminIds = json_decode(env('ADMIN_IDS', '[]'), true);

        return in_array($chatId, $adminIds);
    }
}
