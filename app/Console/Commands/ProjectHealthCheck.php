<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class ProjectHealthCheck extends Command
{
    protected $signature = 'project:health-check';
    protected $description = 'Run full Laravel project diagnostics';

    public function handle()
    {
        $report = "# Project Health Check\n\n";

        // --- Tables ---
        $report .= "## Database Tables\n";
        $tables = DB::select('SHOW TABLES');
        foreach ($tables as $table) {
            $tableName = array_values((array)$table)[0];
            $report .= "- $tableName\n";
        }

        // --- Models ---
        $report .= "\n## Models\n";
        $models = File::files(app_path('Models'));
        foreach ($models as $model) {
            $report .= "- " . $model->getFilenameWithoutExtension() . "\n";
        }

        // --- Routes ---
        $report .= "\n## Routes\n";
        foreach (Route::getRoutes() as $route) {
            $report .= "- " . $route->uri() . " → " . $route->getActionName() . "\n";
        }

        $path = storage_path('logs/project_health_report.md');
        File::put($path, $report);

        $this->info("Health report generated:");
        $this->info($path);
    }
}