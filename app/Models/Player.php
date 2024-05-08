<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    public const TELEGRAM_BOT_BASE_URL = 'https://t.me/dev_kombat_bot';

    protected $fillable = [
        'username', 'chat_id',
        'taps', 'multiplier',
        'score', 'balance',
        'referrer_id',
        'checkin',
    ];

    protected $appends = [
        'referral_link',
        'server_time',
    ];

    public function getReferralLinkAttribute()
    {
        return self::TELEGRAM_BOT_BASE_URL . '?start=' . $this->chat_id;
    }
    public function getServerTimeAttribute()
    {
        return now();
    }

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

    public function referrer()
    {
        return $this->belongsTo(Player::class, 'referrer_id', 'id');
    }

    public function referrals()
    {
        return $this->hasMany(Player::class, 'referrer_id', 'id');
    }

    public function getPositionAttribute()
    {
        if ($this->raiting) {
            return $this->raiting->avg_rating;
        }
        return null;
    }

    public function raiting()
    {
        return $this->hasOne(PlayerBalanceRating::class);
    }
}
