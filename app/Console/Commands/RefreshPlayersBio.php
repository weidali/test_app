<?php

namespace App\Console\Commands;

use App\Models\Player;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Sleep;
use Telegram\Bot\Exceptions\TelegramResponseException;
use Telegram\Bot\Laravel\Facades\Telegram;

class RefreshPlayersBio extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:refresh-players-bio';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public int $wait = 4;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $first_name = null;
        $last_name = null;
        $file_id = null;

        $players = Player::select('chat_id')->get();
        foreach ($players as $key => $player) {
            try {
                $photos = Telegram::getUserProfilePhotos([
                    'user_id' => $player->chat_id,
                ]);
                if (config('app.env') !== 'local') {
                    Sleep::for($this->wait)->seconds();
                }
                Log::debug('[RefreshPlayersBioCredentials] getUserProfilePhotos', [
                    'photos' => $photos,
                    'photos' => $player->chat_id,

                ]);
                if ($photos) {
                    $file_id = $photos['photos'][0][0]['file_id'];
                }
                // dump($file_id);
            } catch (TelegramResponseException $e) {
                Log::error('[RefreshPlayersBioCredentials] getUserProfilePhotos', [
                    'error' => $e->getMessage(),
                ]);
            }

            try {
                $chat = Telegram::getChat([
                    'user_id' => $player->chat_id,
                    'chat_id' => $player->chat_id,
                ]);
                if (config('app.env') !== 'local') {
                    Sleep::for($this->wait)->seconds();
                }

                $first_name = $chat['first_name'];
                if (isset($chat['last_name'])) {
                    $last_name = $chat['last_name'];
                }
                if ($chat) {
                    $file_id = $chat['photo']['small_file_id'];
                }
                // $photo = $chat['photo']['small_file_id'];
                // dump($file_id);
            } catch (TelegramResponseException $e) {
                Log::error('[RefreshPlayersBioCredentials] getChat', [
                    'error' => $e->getMessage(),
                ]);
            }

            if (!is_null($first_name)) {
                $player->setAttribute('first_name', $first_name);
            }
            if (!is_null($last_name)) {
                $player->setAttribute('last_name', $last_name);
            }
            if (!is_null($file_id)) {
                $player->setAttribute('file_id', $file_id);
            }
            $player->save();
        }

        Log::info('[CalculatePlayersRatingByBalance]', [
            'count of rated players' => $player->count(),
        ]);
    }
}
