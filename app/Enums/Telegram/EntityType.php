<?php

namespace App\Enums\Telegram;

enum EntityType: string
{
    case PhoneNumber = 'phone_number';
    case BotCommand = 'bot_command';
}
