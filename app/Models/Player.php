<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

class Player extends Model
{
    use HasFactory;

    public const TELEGRAM_BOT_BASE_URL = 'https://t.me/dev_kombat_bot';

    protected $fillable = [
        'username', 'chat_id',
        'taps', 'multiplier',
        'score', 'balance',
        'referrer_id',
        'last_sync_update',
        'first_name',
        'last_name',
        'is_premium',
        'file_id',
        'main_stack_id',
        'level_id',
        'theme',
        'max_taps',
        'available_taps',
        'earn_per_tap',
    ];

    protected $appends = [
        'referral_link',
        'server_time',
        'main_stack',
        'level',
    ];

    public function getReferralLinkAttribute()
    {
        return self::TELEGRAM_BOT_BASE_URL . '?start=' . $this->chat_id;
    }
    public function getServerTimeAttribute()
    {
        return date('Y-m-d H:i:s');
        return Date::now();
        return Carbon::now("Europe/Moscow");
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
            if (!$player->isDirty('checkin')) {
                $player->checkin = date('Y-m-d H:i:s');
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

    public function getMainStackAttribute()
    {
        if ($this->main_stack_relation) {
            return $this->main_stack_relation->title;
        }
        return null;
    }

    public function main_stack_relation()
    {
        return $this->hasOne(Stack::class, 'id', 'main_stack_id');
    }

    public function level_relation()
    {
        return $this->belongsTo(Level::class);
    }

    public function checkLevelPosition(): int
    {
        $position = 1;
        switch (true) {
            case $this->balance < Level::LEVEL_GRADE_2['value']:
                $position = Level::LEVEL_GRADE_1['position'];
                break;

            case $this->balance < Level::LEVEL_GRADE_3['value']:
                $position = Level::LEVEL_GRADE_2['position'];
                break;

            case $this->balance < Level::LEVEL_GRADE_4['value']:
                $position = Level::LEVEL_GRADE_3['position'];
                break;

            case $this->balance < Level::LEVEL_GRADE_5['value']:
                $position = Level::LEVEL_GRADE_4['position'];
                break;

            case $this->balance < Level::LEVEL_GRADE_6['value']:
                $position = Level::LEVEL_GRADE_5['position'];
                break;

            case $this->balance < Level::LEVEL_GRADE_7['value']:
                $position = Level::LEVEL_GRADE_6['position'];
                break;

            case $this->balance < Level::LEVEL_GRADE_8['value']:
                $position = Level::LEVEL_GRADE_7['position'];
                break;

            case $this->balance < Level::LEVEL_GRADE_8['value']:
                $position = Level::LEVEL_GRADE_8;
                break;

            default:
                $position = Level::LEVEL_GRADE_1;
                break;
        }

        return Level::where('position', $position)->first()->id;
    }

    public function setLevelAttribute($value): void
    {
        $this->attributes['level_id'] = $value;
    }

    public function getLevelAttribute(): string
    {
        if ($this->level_relation) {
            return $this->level_relation->title;
        }
        $position = $this->checkLevelPosition();

        return Level::where('position', $position)->first()->title;
    }
}
