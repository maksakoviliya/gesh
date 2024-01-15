<?php

declare(strict_types=1);

namespace App\Console\Commands\Telegram;

use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as ConsoleCommand;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Laravel\Facades\Telegram;

final class RefreshCommandsList extends Command
{
    protected $signature = 'refresh-commands-list';

    protected $description = 'Refresh telegram commands list';

    public function handle()
    {
        try {
            $this->info('Started telegram commands sync');
            $commands = Telegram::getCommands();

            $telegram = new Api(config('services.telegram-bot-api.token'));

            $data = [];
            foreach ($commands as $command) {
                //                $this->info("$command->getName(), $command->getDescription()");
                if ($command->in_menu) {
                    $data[] = (object) [
                        'command' => $command->getName(),
                        'description' => $command->getDescription(),
                    ];
                }
            }
            $telegram->setMyCommands([
                'commands' => $data,
            ]);
            $this->info('Finished telegram commands sync');

            return ConsoleCommand::SUCCESS;
        } catch (TelegramSDKException $e) {
            $this->error($e->getMessage());

            return ConsoleCommand::INVALID;
        }
    }
}
