<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
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

        $adminIds = json_decode(env('ADMIN_IDS', '[]'), true);
        $text = "*ADMIN MODE* " . PHP_EOL . PHP_EOL;
        $text .= "Chaned url: " . config('app.url');

        foreach ($adminIds as $chatId) {
            $this->telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'MarkDown',
            ]);
        }

        return true;
    }
}
