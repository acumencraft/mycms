<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('archvadze:generate-demo-data', function () {
    $this->comment('Running migrations and seeding demo data...');

    // Ensure migrations are fresh and seed demo data.
    $exitCode = Artisan::call('migrate:fresh', [
        '--seed' => true,
        '--force' => true,
    ]);

    if ($exitCode === 0) {
        $this->info('Demo data successfully generated.');
    } else {
        $this->error('Demo data generation failed. See the output above for details.');
    }
})->purpose('Generate demo/test data across the platform (services, projects, publications, etc.)');
