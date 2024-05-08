<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerBalanceRating extends Model
{
    use HasFactory;

    public const SHOW_LIMIT = 100;

    protected $fillable = [
        'player_id',
        'avg_rating',
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public static function setRating(int $count = 0)
    {
        if ($count == 0) {
            $players = Player::query()
                ->select(['id', 'username', 'balance'])
                ->orderBy('balance', 'desc')
                ->get();
        } else {
            $players = Player::query()
                ->select(['id', 'username', 'balance'])
                ->orderBy('balance', 'desc')
                ->limit($count)
                ->get();
        }


        foreach ($players as $key => $player) {
            self::updateOrCreate(['player_id' => $player->id], [
                'player_id' => $player->id,
                'avg_rating' => $key + 1,
            ]);
        }
    }
}
