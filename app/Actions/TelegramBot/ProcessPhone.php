<?php

declare(strict_types=1);

namespace App\Actions\TelegramBot;

class ProcessPhone
{
    public function handle(string $text)
    {
        \Log::info('Phone is: '.$text);
    }
}
