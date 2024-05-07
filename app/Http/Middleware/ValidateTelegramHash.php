<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateTelegramHash
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $initData = $request->header('X-Telegram-WebApp-initData');
        if (is_null($initData) || $initData == '') {
            return response()->json('Wrong credentials', 422);
        }
        $botToken = env('TELEGRAM_BOT_TOKEN');

        [$checksum, $sortedInitData] = self::convertInitData($initData);
        $secretKey                   = hash_hmac('sha256', $botToken, 'WebAppData', true);
        $hash                        = bin2hex(hash_hmac('sha256', $sortedInitData, $secretKey, true));

        if (strcmp($hash, $checksum) === 0) {
            // validation success

            return $next($request);
        } else {
            // validation failed
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    /**
     * convert init data to `key=value` and sort it `alphabetically`.
     *
     * @param string $initData init data from Telegram (`Telegram.WebApp.initData`)
     *
     * @return string[] return hash and sorted init data
     */
    private static function convertInitData(string $initData): array
    {
        $initDataArray = explode('&', rawurldecode($initData));
        $needle        = 'hash=';
        $hash          = '';

        foreach ($initDataArray as &$data) {
            if (substr($data, 0, \strlen($needle)) === $needle) {
                $hash = substr_replace($data, '', 0, \strlen($needle));
                $data = null;
            }
        }
        $initDataArray = array_filter($initDataArray);
        sort($initDataArray);

        return [$hash, implode("\n", $initDataArray)];
    }
}
