<?php
namespace App\Console\Commands;

use App\Models\DownloadLog;
use App\Models\Visit;
use App\Models\ActivityLog;
use Illuminate\Console\Command;

class CleanOldLogs extends Command
{
    protected $signature = 'logs:clean {--dry-run : Show what would be deleted without deleting}';
    protected $description = 'Clean old logs from database';

    public function handle(): void
    {
        $dryRun = $this->option('dry-run');

        // Download logs — 1 წელზე ძველი
        $downloadCount = DownloadLog::where('downloaded_at', '<', now()->subYear())->count();
        $this->info("Download logs to delete: {$downloadCount}");
        if (!$dryRun) {
            DownloadLog::where('downloaded_at', '<', now()->subYear())->delete();
        }

        // Visits — 6 თვეზე ძველი
        $visitCount = Visit::where('created_at', '<', now()->subMonths(6))->count();
        $this->info("Visits to delete: {$visitCount}");
        if (!$dryRun) {
            Visit::where('created_at', '<', now()->subMonths(6))->delete();
        }

        // Activity log — 3 თვეზე ძველი
        $activityCount = \Spatie\Activitylog\Models\Activity::where('created_at', '<', now()->subMonths(3))->count();
        $this->info("Activity logs to delete: {$activityCount}");
        if (!$dryRun) {
            \Spatie\Activitylog\Models\Activity::where('created_at', '<', now()->subMonths(3))->delete();
        }

        if ($dryRun) {
            $this->warn('Dry run — nothing deleted.');
        } else {
            $this->info('Old logs cleaned successfully!');
        }
    }
}
