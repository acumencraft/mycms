<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Feature;
use App\Models\Guide;
use App\Models\GuideCategory;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\Poll;
use App\Models\PollOption;
use App\Models\PollVote;
use App\Models\PortfolioProject;
use App\Models\Project;
use App\Models\ProjectMessage;
use App\Models\Publication;
use App\Models\PublicationCategory;
use App\Models\PublicationTag;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database with test data.
     */
    public function run(): void
    {
        // Create roles if not exist
        $roles = ['Super Admin', 'Admin', 'Editor', 'Support', 'Client'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Create admin user
        $admin = User::firstOrCreate([
            'email' => 'admin@archvadze.com',
        ], [
            'name' => 'Super Admin',
            'email' => 'admin@archvadze.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        $admin->assignRole('Super Admin');

        // Create client users (10 users with client role)
        $clientUsers = User::factory()->count(10)->create();
        foreach ($clientUsers as $user) {
            $user->assignRole('Client');
        }

        // Create clients (10 clients)
        $clients = Client::factory()->count(10)->create([
            'user_id' => $clientUsers->random()->id,
        ]);

        // Create services (10 services)
        $services = Service::factory()->count(10)->create();

        // Create features (additional features for orders)
        $features = Feature::factory()->count(10)->create();

        // Create portfolio projects (20 projects)
        $portfolioProjects = PortfolioProject::factory()->count(20)->create([
            'client_id' => $clients->random()->id,
        ]);

        // Create portfolio images for each portfolio project (2-5 images per project)
        foreach ($portfolioProjects as $portfolioProject) {
            \App\Models\PortfolioImage::factory()->count(rand(2, 5))->create([
                'portfolio_project_id' => $portfolioProject->id,
            ]);
        }

        // Create publication categories and tags
        $publicationCategories = PublicationCategory::factory()->count(5)->create();
        $publicationTags = PublicationTag::factory()->count(15)->create();

        // Create publications (15 publications)
        $publications = Publication::factory()->count(15)->create([
            'author_id' => $admin->id,
        ]);

        // Attach random categories and tags to publications
        foreach ($publications as $publication) {
            $publication->categories()->attach(
                $publicationCategories->random(rand(1, 3))->pluck('id')
            );
            $publication->tags()->attach(
                $publicationTags->random(rand(2, 5))->pluck('id')
            );
        }

        // Create testimonials (10 testimonials)
        $testimonials = Testimonial::factory()->count(10)->create([
            'client_id' => $clients->random()->id,
        ]);

        // Create polls (3 polls)
        $polls = Poll::factory()->count(3)->create();

        // Create poll options for each poll (3-4 options per poll)
        foreach ($polls as $poll) {
            $pollOptions = PollOption::factory()->count(rand(3, 4))->create([
                'poll_id' => $poll->id,
            ]);
            // Create votes for each option (random votes)
            foreach ($pollOptions as $option) {
                PollVote::factory()->count(rand(0, 10))->create([
                    'poll_id' => $poll->id,
                    'poll_option_id' => $option->id,
                    'user_id' => $clientUsers->random()->id,
                ]);
            }
        }

        // Create guide categories
        $guideCategories = GuideCategory::factory()->count(5)->create();

        // Create guides (5 guides)
        $guides = Guide::factory()->count(5)->create([
            'guide_category_id' => $guideCategories->random()->id,
        ]);

        // Create FAQ categories
        $faqCategories = FaqCategory::factory()->count(3)->create();

        // Create FAQ (10 questions)
        Faq::factory()->count(10)->create([
            'category_id' => $faqCategories->random()->id,
        ]);

        // Create projects for clients (30 projects total)
        $projects = Project::factory()->count(30)->create([
            'client_id' => $clients->random()->id,
        ]);

        // Create project messages (100 messages)
        ProjectMessage::factory()->count(100)->create([
            'project_id' => $projects->random()->id,
            'sender_id' => collect([$admin->id])->merge($clientUsers->pluck('id'))->random(),
        ]);

        // Create orders (20 orders)
        $orders = Order::factory()->count(20)->create([
            'client_id' => $clients->random()->id,
        ]);

        // Attach services and features to orders
        foreach ($orders as $order) {
            $order->services()->attach(
                $services->random(rand(1, 3))->pluck('id')
            );
            $order->features()->attach(
                $features->random(rand(0, 2))->pluck('id')
            );
        }

        $this->command->info('Test data seeding completed!');
        $this->command->info('Created:');
        $this->command->info('- ' . $clientUsers->count() . ' client users');
        $this->command->info('- ' . $clients->count() . ' clients');
        $this->command->info('- ' . $services->count() . ' services');
        $this->command->info('- ' . $features->count() . ' features');
        $this->command->info('- ' . $portfolioProjects->count() . ' portfolio projects');
        $this->command->info('- ' . $publications->count() . ' publications');
        $this->command->info('- ' . $testimonials->count() . ' testimonials');
        $this->command->info('- ' . $polls->count() . ' polls');
        $this->command->info('- ' . $guides->count() . ' guides');
        $this->command->info('- ' . Project::count() . ' client projects');
    }
}
