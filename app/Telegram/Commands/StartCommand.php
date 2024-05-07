<?php

namespace App\Telegram\Commands;

use App\Models\Player;
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
		$chatId = $message->getChat()->id;
		$username = $message->from->username;
		$t = $message->getText(true);

		// Log::debug('[StartCommand]', [
		// 	'args' => $args,
		// 	'response' => $response,
		// 	'message' => $message,
		// 	'text' => $t,
		// ]);
		$ref_player_id = null;
		$pecah = explode(' ', $t, 3);
		$referrer = $pecah[1] ?? null;

		if ($referrer) {
			$ref_player = Player::where('chat_id', $referrer)->first();
			$ref_player_id = $ref_player->id;
		}
		$player = Player::firstOrCreate(['chat_id' => $chatId], [
			'username' => $username,
			'referrer_id' => $ref_player_id,
		]);

		$text = 'Hey, there!' . PHP_EOL;
		$text .= '💽 Welcome to *Dev Kombat*!' . PHP_EOL . PHP_EOL;
		$text .= '/help to Get a list of available commands' . PHP_EOL;

		$this->replyWithMessage([
			'text' => $text,
			'parse_mode' => 'MarkDown',
		]);
	}
}
