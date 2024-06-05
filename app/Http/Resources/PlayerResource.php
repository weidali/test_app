<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'username' => $this->username,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'is_premium' => $this->is_premium,
            'file_id' => $this->file_id,
            'score' => $this->score,
            'balance' => $this->balance,
            'multiplier' => $this->multiplier,
            'referral_link' => $this->referral_link,
            'referrer' => self::make($this->whenLoaded('referrer')),
            'referrals' => self::collection($this->whenLoaded('referrals')),
            'last_sync_update' => $this->last_sync_update,
            'server_time' => $this->server_time,
            'position' => $this->position ?? null,
            'created_at' => $this->created_at,
            'stacks' => [],
            'main_stack' => $this->main_stack,
            'level' => $this->level,
            'theme' => $this->theme,
            'max_taps' => $this->max_taps,
            'available_taps' => $this->available_taps,
            'earn_per_tap' => $this->earn_per_tap,

            'earn_passive_per_sec' => $this->earn_passive_per_sec,
            'earn_passive_per_hour' => $this->earn_passive_per_hour,
            'last_passive_earn' => $this->last_passive_earn,
            'taps_recover_per_sec' => $this->taps_recover_per_sec,

            'is_active' => $this->is_active,
        ];
    }
}
