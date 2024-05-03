<?php

namespace App\Telegram\Commands;

use Telegram\Bot\Commands\Command;

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


		$this->replyWithMessage([
			'text' => $text,
			'parse_mode' => 'MarkDown',
		]);
	}
}
