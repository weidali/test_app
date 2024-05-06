<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Sleep;
use Telegram\Bot\Api;
use Telegram\Bot\Laravel\Facades\Telegram;

class SetTelegramWebhookUrl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-telegram-webhook-url';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set telegram webhook url script';

    protected $telegram;

    /**
     * @param  Api  $telegram
     */
    public function __construct(Api $telegram)
    {
        parent::__construct();
        $this->telegram = $telegram;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = config('telegram.bots.mybot.webhook_url');
        $token = env('CUSTOM_API_TOKEN');
        if (is_null($token) || $token == '') {
            Artisan::call('app:generate-api-token');
        }

        $api_token = hash('sha256', $token);
        Telegram::setWebhook([
            'url' => $url,
            'secret_token' => $api_token, // for “X-Telegram-Bot-Api-Secret-Token”
            'max_connections' => 20,
            'drop_pending_updates' => true,
        ]);
        if (config('app.env') !== 'local') {
            Sleep::for(4)->seconds();
        }

        $adminIds = json_decode(env('ADMIN_IDS', '[]'), true);
        $text = "*ADMIN MODE* " . PHP_EOL . PHP_EOL;
        $text .= 'Api url was changed:' . PHP_EOL;
        $text .= '```' . (config('app.url')) . '```';

        foreach ($adminIds as $chatId) {
            $this->telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'MarkDown',
            ]);
            if (config('app.env') !== 'local') {
                Sleep::for(5)->seconds();
            }
        }

        return true;
    }
}
