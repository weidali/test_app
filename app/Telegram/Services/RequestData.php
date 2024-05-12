<?php

namespace App\Telegram\Services;

use App\Models\Player;
use Illuminate\Http\Request;


class RequestData
{
	public static function getCredentials(string $data): array
	{
		$initDataArray = explode('&', rawurldecode($data));
		$needle_id        = 'user=';

		foreach ($initDataArray as &$data) {
			if (substr($data, 0, \strlen($needle_id)) === $needle_id) {
				$user = substr_replace($data, '', 0, \strlen($needle_id));
				$user_arr = json_decode($user, true);
				$data = null;
			}
		}

		return [$user_arr['id'], $user_arr['username']];
	}

	public static function getChatId(string $data): string
	{
		$initDataArray = explode('&', rawurldecode($data));
		$needle        = 'user=';
		$user          = '';

		foreach ($initDataArray as &$data) {
			if (substr($data, 0, \strlen($needle)) === $needle) {
				$user = substr_replace($data, '', 0, \strlen($needle));
				$user_arr = json_decode($user, true);
				$data = null;
			}
		}
		return $user_arr['id'];
	}

	public static function getPlayerFromRequest(Request $request): Player|null
	{
		$initData = $request->header('X-Telegram-WebApp-initData');
		$chatId  = self::getChatId($initData);

		$player = Player::where('chat_id', $chatId)->first();
		if (!$player)
			return null;

		return $player;
	}
}
