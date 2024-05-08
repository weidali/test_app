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
            'score' => $this->score,
            'balance' => $this->balance,
            'multiplier' => $this->multiplier,
            'referral_link' => $this->referral_link,
            'referrer' => self::make($this->whenLoaded('referrer')),
            'referrals' => self::collection($this->whenLoaded('referrals')),
            'checkin' => $this->checkin,
            'server_time' => $this->server_time,
            'position' => $this->position ?? null,
            'created_at' => $this->created_at,
        ];
    }
}
