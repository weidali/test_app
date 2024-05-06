<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Telegram\Bot\Api;

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

    protected $telegram;

    /**
     * Create a new controller instance.
     *
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
        $adminIds = json_decode(env('ADMIN_IDS', '[]'), true);
        $text = "*ADMIN MODE* " . PHP_EOL . PHP_EOL;
        $text .= "App was DEPLOYED!";

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
