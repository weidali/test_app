<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
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

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = config('telegram.bots.mybot.webhook_url');
        Telegram::setWebhook(['url' => $url]);

        return true;
    }
}
