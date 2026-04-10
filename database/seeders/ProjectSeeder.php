<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Project;
use App\Models\ProjectMessage;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the test client
        $client = Client::where('email', 'client@archvadze.com')->first();
        $admin = User::where('email', 'admin@archvadze.com')->first();

        if ($client && $admin) {
            // Create a test project
            $project = Project::firstOrCreate([
                'title' => 'Test Website Project',
            ], [
                'client_id' => $client->id,
                'title' => 'Test Website Project',
                'description' => 'This is a test project for demonstrating the client dashboard functionality. It includes website development with modern technologies.',
                'status' => 'in_progress',
                'price' => 2500.00,
                'deadline' => now()->addDays(30),
            ]);

            // Create some test messages
            ProjectMessage::firstOrCreate([
                'project_id' => $project->id,
                'sender_id' => $admin->id,
                'message' => 'Welcome to your project! We\'ve started working on your website. Let us know if you have any questions.',
            ]);

            ProjectMessage::firstOrCreate([
                'project_id' => $project->id,
                'sender_id' => $client->user_id,
                'message' => 'Thank you! I\'m excited to see the progress. Please keep me updated.',
            ]);

            ProjectMessage::firstOrCreate([
                'project_id' => $project->id,
                'sender_id' => $admin->id,
                'message' => 'Great! We\'ve completed the initial design mockups. You can expect to see them in your dashboard soon.',
            ]);
        }
    }
}
