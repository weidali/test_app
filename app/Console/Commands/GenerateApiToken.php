<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateApiToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-api-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes a new API Token';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->comment('Creating a new Api Token');

        $token = (string)Str::uuid();
        $api_token = hash('sha256', $token);

        $envKey = 'CUSTOM_API_TOKEN';


        $path = app()->environmentFilePath();
        $env = file_get_contents($path);

        $old_value = env($envKey);
        $new_value = '"' . $token . '"';

        if (!str_contains($env, $envKey . '=')) {
            $env .= sprintf(PHP_EOL . "%s=%s" . PHP_EOL, $envKey, $new_value);
        } else if ($old_value) {
            $env = str_replace(sprintf('%s="%s"', $envKey, $old_value), sprintf('%s=%s', $envKey, $new_value), $env);
        } else {
            $env = str_replace(sprintf('%s=', $envKey), sprintf('%s=%s', $envKey, $new_value), $env);
        }

        file_put_contents($path, $env);
        $this->comment($api_token);

        return 1;
    }
}
