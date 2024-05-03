<?php

namespace App\Telegram\Commands;

use Telegram\Bot\Commands\Command;

class SettingsCommand extends Command
{
	protected string $name = 'settings';
	protected string $description = 'settings Command';

	public function handle()
	{
		$this->replyWithMessage([
			'text' => 'settings',
			'parse_mode' => 'MarkDown',
		]);
	}
}
