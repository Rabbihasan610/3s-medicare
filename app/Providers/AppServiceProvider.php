<?php

namespace App\Providers;

use App\Constants\Status;
use App\Lib\SidebarCounter;
use App\Models\AdminNotification;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {


        $viewShare['general'] = gs();
        $viewShare['emptyMessage'] = 'Data not found';
        view()->share($viewShare);

        view()->composer('admin.partials.sidenav', function ($view) {
            // One cached round trip for every badge in the sidebar.
            $counts = SidebarCounter::counts();

            $view->with([
                'sidebarCounts' => $counts,
                'emailUnverifiedUsersCount' => $counts['users_email_unverified'] ?? 0,
                'mobileUnverifiedUsersCount' => $counts['users_mobile_unverified'] ?? 0,
                'pendingSupportCount' => $counts['support'] ?? 0,
            ]);
        });

        view()->composer('admin.partials.topnav', function ($view) {
            $view->with([
                'adminNotifications' => AdminNotification::where('is_read', Status::NO)->with('user')->orderBy('id', 'desc')->take(10)->get(),
                'adminNotificationCount' => AdminNotification::where('is_read', Status::NO)->count(),
            ]);
        });

        Paginator::useBootstrapFour();
    }
}
