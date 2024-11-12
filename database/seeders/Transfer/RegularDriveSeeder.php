<?php

declare(strict_types=1);

namespace Database\Seeders\Transfer;

use App\Models\Transfer\RegularDrive;
use Illuminate\Database\Seeder;

final class RegularDriveSeeder extends Seeder
{
    public function run(): void
    {
        RegularDrive::factory(2)
            ->create();
    }
}
