<?php

namespace App\Telegram\Commands;

use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
	protected string $name = 'start';
	protected array $aliases = ['subscribe'];
	protected string $description = 'Start Command to get you started';

	public function handle()
	{
		$inline_keyboard = [
			['Играть'],
			['Профиль']
		];

		$inlineMarkup = [
			'inline_keyboard' => $inline_keyboard,
		];

		$this->replyWithMessage([
			'text' => 'Hey, there!' . PHP_EOL . 'Welcome to *Dev Kombat*!',
			'parse_mode' => 'MarkDown',
			'inline_markup' => json_encode($inlineMarkup),
		]);
	}
}
