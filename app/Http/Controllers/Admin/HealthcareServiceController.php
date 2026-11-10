<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HealthcareService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HealthcareServiceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $group = $request->group;

        $services = HealthcareService::query()
            ->when($group && $group != 'all', function ($q) use ($group) {
                return $q->where('group_key', $group);
            })
            ->when($search, function ($q) use ($search) {
                return $q->where(function ($sub) use ($search) {
                    $sub->where('title', 'like', "%$search%")
                        ->orWhere('group_name', 'like', "%$search%")
                        ->orWhere('short_description', 'like', "%$search%");
                });
            })
            ->orderBy('group_key')
            ->orderBy('sort_order')
            ->paginate(20)
            ->withQueryString();

        $pageTitle = 'Healthcare Services Catalog';
        $groups = [
            'digital_presence' => 'Group 01: Digital Presence',
            'marketing_creative' => 'Group 02: Marketing & Creative',
            'patient_services' => 'Group 03: Patient-Focused Digital Services',
        ];

        return view('admin.services.index', compact('services', 'pageTitle', 'groups'));
    }

    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'title' => 'required|string|max:120',
            'group_key' => 'required|in:digital_presence,marketing_creative,patient_services',
            'short_description' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
        ]);

        $groupNames = [
            'digital_presence' => 'Digital Presence',
            'marketing_creative' => 'Marketing & Creative',
            'patient_services' => 'Patient-Focused Digital Services',
        ];

        if ($id) {
            $service = HealthcareService::findOrFail($id);
            $notifyMessage = 'Service updated successfully';
        } else {
            $service = new HealthcareService();
            $notifyMessage = 'Service created successfully';
        }

        $service->title = $request->title;
        $service->slug = Str::slug($request->title);
        $service->group_key = $request->group_key;
        $service->group_name = $groupNames[$request->group_key] ?? 'General';
        $service->icon = $request->icon ?? 'bi-window';
        $service->short_description = $request->short_description;
        $service->description = $request->description;
        $service->sort_order = $request->sort_order ?? 0;
        $service->is_active = $request->has('is_active') ? true : false;
        $service->save();

        $notify[] = ['success', $notifyMessage];
        return back()->withNotify($notify);
    }

    public function status($id)
    {
        $service = HealthcareService::findOrFail($id);
        $service->is_active = !$service->is_active;
        $service->save();

        $notify[] = ['success', 'Status toggled successfully'];
        return back()->withNotify($notify);
    }

    public function destroy($id)
    {
        $service = HealthcareService::findOrFail($id);
        $service->delete();

        $notify[] = ['success', 'Service deleted successfully'];
        return back()->withNotify($notify);
    }
}

