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
		Log::debug($args);


		$response = $this->getUpdate();

		$text = 'Hey stranger, thanks for visiting me.' . chr(10) . chr(10);
		$text .= 'You send me a test command with following arguments:' . chr(10) . chr(10);
		$text .= 'ID: ' . $args['id'] . chr(10);
		$text .= 'Status: ' . $args['status'] . chr(10) . chr(10);
		$text .= 'Keep up the good work!' . chr(10);

		$this->replyWithMessage(compact('text'));

		return;

		$text = 'Hey, there!' . PHP_EOL;
		$text .= 'Welcome to *Dev Kombat*!' . PHP_EOL . PHP_EOL;
		$text .= '/help to Get a list of available commands' . PHP_EOL;


		if ($this->getArguments()) {
			$args = $this->getArguments();
			Log::debug('args'[$args]);
		}
		$update = \Telegram\Bot\Laravel\Facades\Telegram::commandsHandler(true);

		// $message->getText(true);
		Log::debug('[StartCommand]handle', [
			$update
		]);

		$this->replyWithMessage([
			'text' => $text,
			'parse_mode' => 'MarkDown',
		]);
	}
}
