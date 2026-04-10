<?php
namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ProjectMessage;
use App\Models\ProjectFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClientDashboardController extends Controller
{
    private function getOrCreateClient()
    {
        $user = Auth::user();
        $client = $user->client;
        if (!$client) {
            $client = Client::create([
                'user_id' => $user->id,
                'name'    => $user->name,
                'email'   => $user->email,
                'phone'   => null,
                'company' => null,
                'country' => null,
            ]);
        }
        return $client;
    }

    public function index()
    {
        $client = $this->getOrCreateClient();

        $projects = $client->projects()
            ->with(['messages' => fn($q) => $q->latest()->limit(3)])
            ->latest()
            ->get();

        // orders ერთხელ ჩავტვირთოთ — collection-ს ვიყენებთ ქვემოთაც
        $orders = $client->orders()->latest()->take(5)->get();

        $recentMessages = ProjectMessage::whereIn('project_id', $projects->pluck('id'))
            ->where('sender_id', '!=', Auth::id())
            ->with('project')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // ყველა stat collection-იდან — არცერთი ზედმეტი DB query
        $stats = [
            'total_projects'     => $projects->count(),
            'active_projects'    => $projects->where('status', 'in_progress')->count(),
            'completed_projects' => $projects->where('status', 'completed')->count(),
            'total_orders'       => $orders->count(), // იყო: $client->orders()->count() — ზედმეტი query
        ];

        return view('client-dashboard.index', compact('projects', 'orders', 'recentMessages', 'stats'));
    }

    public function project($id)
    {
        $client = $this->getOrCreateClient();
        $project = $client->projects()->findOrFail($id);
        $messages = $project->messages()->with('sender')->orderBy('created_at')->get();
        $files = $project->files()->orderBy('created_at', 'desc')->get();
        return view('client-dashboard.project', compact('project', 'messages', 'files'));
    }

    public function sendMessage(Request $request, $projectId)
    {
        $request->validate(['message' => 'required|string|max:1000']);
        $client = $this->getOrCreateClient();
        $project = $client->projects()->findOrFail($projectId);
        ProjectMessage::create([
            'project_id' => $project->id,
            'sender_id'  => Auth::id(),
            'message'    => $request->message,
        ]);
        return back()->with('success', 'Message sent successfully.');
    }

    public function uploadFile(Request $request, $projectId)
    {
        $request->validate(['file' => 'required|file|max:10240']);
        $client = $this->getOrCreateClient();
        $project = $client->projects()->findOrFail($projectId);
        $path = $request->file('file')->store('project-files', 'public');
        ProjectFile::create([
            'project_id'  => $project->id,
            'file_path'   => $path,
            'uploaded_by' => Auth::id(),
        ]);
        return back()->with('success', 'File uploaded successfully.');
    }

    public function editProfile()
    {
        return view('profile.edit');
    }

    public function downloadFile($fileId)
    {
        $client = $this->getOrCreateClient();
        $file = ProjectFile::whereHas('project', function ($query) use ($client) {
            $query->where('client_id', $client->id);
        })->findOrFail($fileId);
        return Storage::disk('public')->download($file->file_path);
    }
}
