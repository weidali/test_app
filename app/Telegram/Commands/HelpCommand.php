<?php

namespace App\Telegram\Commands;

use Telegram\Bot\Commands\Command;

class HelpCommand extends Command
{
	protected string $name = 'help';
	protected array $aliases = ['listcommands'];
	protected string $description = 'Get a list of available commands';

	public function handle(): void
	{
		$commands = $this->telegram->getCommandBus()->getCommands();

		$text = 'Available commands:' . PHP_EOL . PHP_EOL;
		foreach ($commands as $name => $handler) {
			$text .= sprintf('/%s - %s' . PHP_EOL, $name, $handler->getDescription());
		}

		$this->replyWithMessage(['text' => $text]);
	}
}
