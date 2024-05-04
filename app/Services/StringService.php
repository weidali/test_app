<?php

namespace App\Services;

class StringService
{
	public function concatenate($string1, $string2)
	{
		return $string1 . $string2;
	}

	public function trim($string)
	{
		return trim($string);
	}

	public function length($string)
	{
		return strlen($string);
	}

	public static function toEscapeMsg(string $str): string
	{
		return preg_replace([
			'/_/',
			'/-/',
			'/~/',
			'/`/',
			'/\./',
			'/\*/',
		], [
			'\\_',
			'\\-',
			'\\~',
			'\\`',
			'\\.',
			'\\*',
		], $str);
	}
}
