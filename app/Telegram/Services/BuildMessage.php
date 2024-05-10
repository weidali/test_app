<?php

namespace App\Telegram\Services;

class BuildMessage
{
	public function getExampleMessage(
		string $chat_id,
		string $full_name,
		string $username,
		string $contact = '',
		string $location = ''
	) {
		return [
			'chat_id' => $chat_id,
			'text' => "Hey some one just submit in our bot:
			name 👤 : $full_name
			id 🗣 : @$username
			phone number 📱 : $contact
			address 📫 : $location 
			zip code 📦 : 
			",
		];
	}
}
