<?php

namespace App\Telegram\Commands;

use App\Models\Player;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Commands\Command;

class ProfileCommand extends Command
{
	protected string $name = 'profile';
	protected array $aliases = ['me'];
	protected string $description = 'Profile Command';

	public function handle()
	{
		// $update = $this->getUpdates();
		$update = $this->getUpdate()->getMessage();
		$update_array = json_decode($update, TRUE);

		$chatId = $update_array["chat"]["id"];
		$text = $update_array["text"];
		$username = $update_array["from"]['username'];

		$player = Player::firstOrCreate(['chat_id' => $chatId], [
			'username' => $username,
		]);

		$score = $player->score;
		$balance = $player->balance;
		$username = $player->username;
		$league = 'Diamond League';

		$text = "@$username *profile* " . PHP_EOL . PHP_EOL;
		$text .= "🏆 " . $league . PHP_EOL . "🪙 Total score: " . $score . PHP_EOL . "🪙 Balance: " . $balance . PHP_EOL . PHP_EOL;
		$text .= "/profile for personal stats" . PHP_EOL;
		if (Player::isAdmin($chatId)) {
			$text .= "/admin for admin mode";
		}

		$this->replyWithMessage([
			'text' => $text,
			'parse_mode' => 'MarkDown',
		]);
	}
}
