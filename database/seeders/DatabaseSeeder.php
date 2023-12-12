<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Apartment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //        User::factory(10)->create();
//        Apartment::query()->truncate();
//        Media::query()->truncate();
//        Apartment::factory(30)->create();

                $role = Role::create(['name' => 'admin']);
                $admin = User::factory()->create([
                    'name' => 'Admin',
                    'email' => 'admin@admin.admin',
                    'email_verified_at' => Carbon::now(),
                    'password' => Hash::make('123123123'),
                ]);
                $user = User::factory()->create([
                    'name' => 'Василий',
                    'email' => 'Tezis1993@yandex.ru',
                    'email_verified_at' => Carbon::now(),
                    'password' => Hash::make('123123123'),
                ]);
                $admin->assignRole($role);
                $user->assignRole($role);
    }
}
