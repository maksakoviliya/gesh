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

    /**
     * @throws TelegramSDKException
     */
    public function handle()
    {
        $this->info('Started telegram commands sync');
        if (false) {
            //        try {
            $commands = Telegram::getCommands();

            $telegram = new Api(config('services.telegram-bot-api.token'));

            $data = [];
            foreach ($commands as $command) {
                //                                $this->info(json_encode($command));
                if ($command->in_menu) {
                    $data[] = (object)[
                        'command' => $command->getName(),
                        'description' => strtolower($command->getDescription()),
                    ];
                }
            }
            //        dd($data);
            $telegram->setMyCommands([
                'commands' => $data,
            ]);
            $this->info('Finished telegram commands sync');
        } else {
            $commands = Telegram::bot('transferBot')->getCommands();
            $data = [];
            foreach ($commands as $command) {
                if ($command->in_menu) {
                    $data[] = (object)[
                        'command' => $command->getName(),
                        'description' => strtolower($command->getDescription()),
                    ];
                }
            }

            Telegram::bot('transferBot')->setMyCommands([
                'commands' => $data,
            ]);
        }

        return ConsoleCommand::SUCCESS;
        //        } catch (TelegramSDKException $e) {
        //            $this->error($e->getMessage());
        //
        //            return ConsoleCommand::INVALID;
        //        }
    }
}
