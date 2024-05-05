<?php

namespace App\Telegram\Services;

class RequestData
{
	public static function getChatId(int $data): string
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
}
