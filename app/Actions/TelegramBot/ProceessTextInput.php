<?php

namespace App\Actions\TelegramBot;

class ProceessTextInput
{
    public function handle(string $text)
    {
        \Log::info($text);
    }
}
