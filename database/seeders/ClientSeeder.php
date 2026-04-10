<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test client user
        $clientUser = User::firstOrCreate([
            'email' => 'client@archvadze.com',
        ], [
            'name' => 'Test Client',
            'email' => 'client@archvadze.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        $clientUser->assignRole('Client');

        // Create client record
        Client::firstOrCreate([
            'email' => 'client@archvadze.com',
        ], [
            'user_id' => $clientUser->id,
            'name' => 'Test Client',
            'email' => 'client@archvadze.com',
            'phone' => '+1-555-0123',
            'company' => 'Test Company',
            'country' => 'USA',
        ]);
    }
}
