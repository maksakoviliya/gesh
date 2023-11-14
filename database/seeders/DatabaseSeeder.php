<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Apartment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Apartment::factory(30)->create();

        $role = Role::create(['name' => 'admin']);
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.admin',
            'password' => Hash::make('123123123')
        ]);
        $user->assignRole($role);
    }
}
