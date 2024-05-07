<?php

namespace App\Telegram\Commands;

use App\Models\Player;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Objects\Message;

class FriendCommand extends Command
{
	protected string $name = 'friend';
	protected array $aliases = ['referrer'];
	protected string $description = 'Invite Friends Command';

	public function handle()
	{
		$message = $this->getUpdate()->getMessage();
		if (!$message instanceof Message) {
			Log::debug('instanceof', [$message instanceof Message, $message]);
			return;
		}
		$chatId = $message->getChat()->id;
		$url = Player::TELEGRAM_BOT_BASE_URL . '?start=' . $chatId;

		$text = 'Share *DevKombat* with your firends and earn bonuses for each friend you invite and for their activity.' . PHP_EOL . PHP_EOL;
		$text .= 'Copy and share it' . PHP_EOL;
		$text .= '👉 `' . $url . '`';

		$this->replyWithMessage([
			'parse_mode' => 'MarkDown',
			'text' => $text,
		]);
	}
}
