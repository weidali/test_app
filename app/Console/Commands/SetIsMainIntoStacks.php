<?php

namespace App\Console\Commands;

use App\Models\Stack;
use Illuminate\Console\Command;

class SetIsMainIntoStacks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-is-main-into-stacks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $languages = $this->array_change_value_to_uppercase(Stack::$languages);
        $stacks = Stack::all();

        foreach ($stacks as $stack) {
            foreach ($languages as $title) {
                if (str_contains(strtoupper($stack->title), $title)) {
                    $stack->setAttribute('is_main', true);
                    $stack->save();
                }
            }
        }
    }

    public function array_change_value_to_uppercase(array $input): array
    {
        $result = [];
        foreach ($input as $value) {
            $result[] = strtoupper($value);
        }

        return $result;
    }
}
