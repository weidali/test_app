<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class AppDeployed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:app-deployed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send message to admin when app was deployed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = config('telegram.bots.mybot.webhook_url');

        $adminIds = json_decode(env('ADMIN_IDS', '[]'), true);
        $text = "*ADMIN MODE* " . PHP_EOL . PHP_EOL;
        $text .= "App was DEPLOYED!";

        foreach ($adminIds as $chatId) {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'MarkDown',
            ]);
        }

        return true;
    }
}
