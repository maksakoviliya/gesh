<?php

declare(strict_types=1);

namespace Tests\Feature\Transfer;

use Tests\TestCase;

final class TelegramBotTest extends TestCase
{
    public function test_updates_processing(): void
    {
        $data = json_decode('{"update_id":711211078,"message":{"message_id":12,"from":{"id":381110669,"is_bot":false,"first_name":"Iliya","last_name":"Mmm","username":"maksak_il","language_code":"ru"},"chat":{"id":381110669,"first_name":"Iliya","last_name":"Mmm","username":"maksak_il","type":"private"},"date":1733649917,"text":"\/start","entities":[{"offset":0,"length":6,"type":"bot_command"}]}}');
        dd($data);
    }
}
