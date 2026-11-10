<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $category = $request->category;

        $projects = Project::query()
            ->when($category && $category != 'all', function ($q) use ($category) {
                return $q->where('category', $category);
            })
            ->when($search, function ($q) use ($search) {
                return $q->where(function ($sub) use ($search) {
                    $sub->where('title', 'like', "%$search%")
                        ->orWhere('client_name', 'like', "%$search%")
                        ->orWhere('summary', 'like', "%$search%");
                });
            })
            ->orderBy('sort_order')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $pageTitle = 'Case Studies & Projects';
        $categories = ['Doctor', 'Hospital', 'Clinic', 'Diagnostic Center'];

        return view('admin.projects.index', compact('projects', 'pageTitle', 'categories'));
    }

    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'client_name' => 'nullable|string|max:120',
            'category' => 'required|string|max:80',
            'summary' => 'required|string',
            'thumbnail' => 'nullable|string|max:255',
            'live_url' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        if ($id) {
            $project = Project::findOrFail($id);
            $notifyMessage = 'Project updated successfully';
        } else {
            $project = new Project();
            $notifyMessage = 'Project created successfully';
        }

        $project->title = $request->title;
        $project->slug = Str::slug($request->title);
        $project->client_name = $request->client_name;
        $project->category = $request->category;
        $project->thumbnail = $request->thumbnail ?? 'assets/images/3s/work-showcase.jpg';
        $project->summary = $request->summary;
        $project->live_url = $request->live_url;
        $project->sort_order = $request->sort_order ?? 0;
        $project->is_featured = $request->has('is_featured') ? true : false;
        $project->save();

        $notify[] = ['success', $notifyMessage];
        return back()->withNotify($notify);
    }

    public function featured($id)
    {
        $project = Project::findOrFail($id);
        $project->is_featured = !$project->is_featured;
        $project->save();

        $notify[] = ['success', 'Featured status toggled successfully'];
        return back()->withNotify($notify);
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        $notify[] = ['success', 'Project deleted successfully'];
        return back()->withNotify($notify);
    }
}

