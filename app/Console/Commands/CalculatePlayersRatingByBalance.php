<?php

namespace App\Console\Commands;

use App\Models\PlayerBalanceRating;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CalculatePlayersRatingByBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calculate-players-rating-by-balance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate players position by balance';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Example of scheduled command (assuming that you have reviews relation in player model)
        $res_count = PlayerBalanceRating::setRating();
        Log::info('[CalculatePlayersRatingByBalance]', [
            'count of rated players' => $res_count,
        ]);
    }
}
