<?php

declare(strict_types=1);

namespace App\Console\Commands\Roles;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Spatie\Permission\Models\Role;
use Throwable;

final class CreateRoleCommand extends Command implements PromptsForMissingInput
{
    protected $signature = 'make:role {name}';

    protected $description = 'Create role by its name';

    public function handle(): int
    {
        $name = $this->argument('name');

        try {
            Role::query()
                ->create(['name' => $name]);

            $this->info("Role '$name' created successfully.");
        } catch (Throwable $exception) {
            $this->error('Failed to create role. '.$exception->getMessage());
        }

        return parent::SUCCESS;
    }
}
