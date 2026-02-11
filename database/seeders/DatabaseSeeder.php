<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            RegionSeeder::class,
        ]);

        // Create Super Admin
        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@harimau.org',
            'password' => Hash::make('password'),
        ]);
        $superAdmin->assignRole('super-admin');

        // Create Member User
        $memberUser = User::factory()->create([
            'name' => 'Anggota Contoh',
            'email' => 'anggota@harimau.org',
            'password' => Hash::make('password'),
        ]);
        $memberUser->assignRole('member');
    }
}
