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

		$args = $this->getArguments();
		$response = $this->getUpdate();
		$message = $response->getMessage();
		$t = $message->getText(true);

		Log::debug('[StartCommand]', [
			'args' => $args,
			'response' => $response,
			'message' => $message,
			'text' => $t,
		]);


		$text = 'Hey, there!' . PHP_EOL;
		$text .= 'Welcome to *Dev Kombat*!' . PHP_EOL . PHP_EOL;
		$text .= '/help to Get a list of available commands' . PHP_EOL;

		$this->replyWithMessage(compact('text'));

		return;

		if ($this->getArguments()) {
			$args = $this->getArguments();
			Log::debug('args'[$args]);
		}
		$update = \Telegram\Bot\Laravel\Facades\Telegram::commandsHandler(true);


		Log::debug('[StartCommand]handle', [
			$update
		]);

		$this->replyWithMessage([
			'text' => $text,
			'parse_mode' => 'MarkDown',
		]);
	}
}
