<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Constants\Status;
use App\Lib\DashboardStats;
use App\Models\UserLogin;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use App\Models\AdminNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Clear cached stats so newly registered sources and quotes show up immediately
        Cache::forget(DashboardStats::CACHE_KEY);

        // Requests, people and support in a handful of cached union queries.
        $stats = DashboardStats::all();

        $widget = [
            'total_users' => $stats['people']['users']['total'],
            'verified_users' => $stats['people']['users']['active'],
            'email_unverified_users' => $stats['people']['users']['email_unverified'],
            'mobile_unverified_users' => $stats['people']['users']['mobile_unverified'],
        ];

        // 3S Medi Care metrics
        $quoteCounts = [
            'total' => \App\Models\QuoteRequest::count(),
            'pending' => \App\Models\QuoteRequest::where('status', 'pending')->count(),
            'reviewed' => \App\Models\QuoteRequest::where('status', 'reviewed')->count(),
            'contacted' => \App\Models\QuoteRequest::where('status', 'contacted')->count(),
        ];
        $latestQuotes = \App\Models\QuoteRequest::latest()->take(6)->get();
        $servicesCount = class_exists(\App\Models\HealthcareService::class) ? \App\Models\HealthcareService::count() : 0;
        $subscribersCount = \App\Models\Subscriber::count();
        $assistantQueriesCount = \Illuminate\Support\Facades\DB::table('assistant_queries')->count();
        $pageTitle = 'Healthcare Dashboard';

        // user Browsing, Country, Operating Log
        $userLoginData = UserLogin::where('created_at', '>=', Carbon::now()->subDay(30))->get(['browser', 'os', 'country']);

        $chart['user_browser_counter'] = $userLoginData->groupBy('browser')->map(function ($item, $key) {
            return collect($item)->count();
        });
        $chart['user_os_counter'] = $userLoginData->groupBy('os')->map(function ($item, $key) {
            return collect($item)->count();
        });
        $chart['user_country_counter'] = $userLoginData->groupBy('country')->map(function ($item, $key) {
            return collect($item)->count();
        })->sort()->reverse()->take(5);

        return view('admin.dashboard', compact('chart', 'widget', 'stats', 'quoteCounts', 'latestQuotes', 'servicesCount', 'subscribersCount', 'assistantQueriesCount', 'pageTitle'));
    }

    public function profile()
    {
        $admin = auth('admin')->user();
        return view('admin.profile', compact('admin'));
    }

    public function profileUpdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'image' => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);

        $user = auth('admin')->user();

        if ($request->hasFile('image')) {
            try {
                $old = $user->image;
                $user->image = fileUploader($request->image, getFilePath('adminProfile'), getFileSize('adminProfile'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        $notify[] = ['success', 'Profile updated successfully'];
        return to_route('admin.profile')->withNotify($notify);
    }

    public function password()
    {
        $admin = auth('admin')->user();
        return view('admin.password', compact('admin'));
    }

    public function passwordUpdate(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:5|confirmed',
        ]);

        $user = auth('admin')->user();
        if (!Hash::check($request->old_password, $user->password)) {
            $notify[] = ['error', 'Password doesn\'t match!!'];
            return back()->withNotify($notify);
        }
        $user->password = bcrypt($request->password);
        $user->save();
        $notify[] = ['success', 'Password changed successfully'];
        return to_route('admin.password')->withNotify($notify);
    }

    public function notifications()
    {
        $notifications = AdminNotification::orderBy('id', 'desc')->with('user')->paginate(getPaginate());
        return view('admin.notifications', compact('notifications'));
    }

    public function readAll()
    {
        AdminNotification::where('is_read', Status::NO)->update([
            'is_read' => Status::YES,
        ]);
        $notify[] = ['success', 'Notifications read successfully'];
        return back()->withNotify($notify);
    }

    public function notificationRead($id){
        $notification = AdminNotification::findOrFail($id);
        $notification->is_read = Status::YES;
        $notification->save();
        $url = $notification->click_url;
        if ($url == '#') {
            $url = url()->previous();
        }
        return redirect($url);
    }
}
