<?php

namespace App\Telegram\Commands;

use App\Models\Player;
use App\Services\StringService;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

class ProfileCommand extends Command
{
	protected string $name = 'profile';
	protected array $aliases = ['me'];
	protected string $description = 'Profile Command';

	public function handle()
	{
		$message = $this->getUpdate()->getMessage();
		if (!$message instanceof Message) {
			Log::debug('instanceof', [$message instanceof Message, $message]);
			return;
		}

		$chatId = $message->getChat()->id;
		$text = $message->text;
		$username = $message->from->username;


		$player = Player::firstOrCreate(['chat_id' => $chatId], [
			'username' => $username,
		]);

		$score = $player->score / 100;
		$balance = $player->balance / 100;
		$username = $player->username;
		$username = StringService::toEscapeMsg($username);
		$level = $player->level;;

		$text = 'profile';
		$text = '@' . $username . ' *profile*' . PHP_EOL . PHP_EOL;
		$text .= '🏆 ' . $level . PHP_EOL . '🪙 Total score: ' . $score . PHP_EOL . '🪙 Balance: ' . $balance . PHP_EOL . PHP_EOL;
		$text .= '/profile for personal stats' . PHP_EOL;

		if (Player::isAdmin($chatId)) {
			$text .= "/admin for admin mode" . PHP_EOL;
		}

		$this->replyWithMessage([
			'parse_mode' => 'MarkDown',
			'text' => $text,
		]);
	}
}
