<?php

namespace App\Console\Commands;

use App\Services\StringService;
use Illuminate\Console\Command;
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
        Telegram::setWebhook(['url' => $url]);
        Sleep::for(10)->seconds();

        $adminIds = json_decode(env('ADMIN_IDS', '[]'), true);
        $text = "*ADMIN MODE* " . PHP_EOL . PHP_EOL;
        $text .= 'Api url was changed:' . PHP_EOL;
        $text .= '\\`' . StringService::toEscapeMsg(config('app.url')) . '\\`';

        foreach ($adminIds as $chatId) {
            $this->telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'MarkDown',
            ]);
            Sleep::for(10)->seconds();
        }

        return true;
    }
}
