<?php
namespace App\Observers;

use App\Models\Project;
use App\Models\PortfolioProject;
use Illuminate\Support\Str;

class ProjectObserver
{
    public function updated(Project $project): void
    {
        if ($project->wasChanged('status') && $project->status === 'completed') {
            $this->createPortfolioProject($project);
        }
    }

    private function createPortfolioProject(Project $project): void
    {
        // უკვე არსებობს?
        $exists = PortfolioProject::where('client_id', $project->client_id)
            ->where('title', $project->title)
            ->exists();

        if (!$exists) {
            PortfolioProject::create([
                'client_id'    => $project->client_id,
                'title'        => $project->title,
                'slug'         => Str::slug($project->title) . '-' . $project->id,
                'description'  => $project->description,
                'completed_at' => now(),
                'is_featured'  => false,
                'is_published' => false, // ადმინი თვითონ გამოაქვეყნებს review-ის შემდეგ
            ]);
        }
    }
}
