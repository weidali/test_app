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
            'balance' => $this->balance,
            'score' => $this->score,
            'multiplier' => $this->multiplier,
            'referral_link' => $this->referral_link,
            'referrer' => self::make($this->whenLoaded('referrer')),
            'referrals' => self::collection($this->whenLoaded('referrals')),
            'created_at' => $this->created_at,
        ];
    }
}
