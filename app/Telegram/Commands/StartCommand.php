<?php

namespace App\Telegram\Commands;

use Illuminate\Support\Facades\Log;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Objects\Keyboard\InlineKeyboardButton;
use Telegram\Bot\Objects\Keyboard\InlineKeyboardMarkup;

class StartCommand extends Command
{
	protected string $name = 'start';
	protected array $aliases = ['subscribe'];
	protected string $description = 'Start Command to init your started';

	public function handle()
	{
		$text = 'Hey, there!' . PHP_EOL;
		$text .= 'Welcome to *Dev Kombat*!' . PHP_EOL . PHP_EOL;
		$text .= '/help to Get a list of available commands' . PHP_EOL;


		$update = \Telegram\Bot\Laravel\Facades\Telegram::commandsHandler(true);

		Log::debug('[handleWebhook]instanceof', [
			$update
		]);

		$this->replyWithMessage([
			'text' => $text,
			'parse_mode' => 'MarkDown',
		]);
	}
}
