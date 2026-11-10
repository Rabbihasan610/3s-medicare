<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Frontend;
use App\Models\GeneralSetting;
use App\Models\HealthcareService;
use App\Models\Page;
use App\Models\Project;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class GeneralSettingController extends Controller
{
    public function index()
    {
        $timezones = json_decode(file_get_contents(resource_path('views/admin/partials/timezone.json')));
        $currentTimezone = array_search(config('app.timezone'), $timezones);
        return view('admin.setting.general', compact('timezones', 'currentTimezone'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:40',
            'cur_text' => 'required|string|max:40',
            'cur_sym' => 'required|string|max:40',
            'timezone' => 'required|integer',
        ]);

        $timezones = json_decode(file_get_contents(resource_path('views/admin/partials/timezone.json')));
        $timezone = @$timezones[$request->timezone] ?? 'UTC';

        $general = gs();
        $general->site_name = $request->site_name;
        $general->cur_text = $request->cur_text;
        $general->cur_sym = $request->cur_sym;
        $general->save();

        $timezoneFile = config_path('timezone.php');
        $content = '<?php $timezone = "' . $timezone . '" ?>';
        file_put_contents($timezoneFile, $content);
        $notify[] = ['success', 'General setting updated successfully'];
        return back()->withNotify($notify);
    }

    public function systemConfiguration()
    {
        return view('admin.setting.configuration');
    }

    public function systemConfigurationSubmit(Request $request)
    {
        $general = gs();
        $general->ev = $request->ev ? Status::ENABLE : Status::DISABLE;
        $general->en = $request->en ? Status::ENABLE : Status::DISABLE;
        $general->sv = $request->sv ? Status::ENABLE : Status::DISABLE;
        $general->sn = $request->sn ? Status::ENABLE : Status::DISABLE;
        $general->force_ssl = $request->force_ssl ? Status::ENABLE : Status::DISABLE;
        $general->secure_password = $request->secure_password ? Status::ENABLE : Status::DISABLE;
        $general->registration = $request->registration ? Status::ENABLE : Status::DISABLE;
        $general->agree = $request->agree ? Status::ENABLE : Status::DISABLE;
        $general->multi_language = $request->multi_language ? Status::ENABLE : Status::DISABLE;
        $general->save();
        $notify[] = ['success', 'System configuration updated successfully'];
        return back()->withNotify($notify);
    }

    public function logoIcon()
    {
        return view('admin.setting.logo_icon');
    }

    public function logoIconUpdate(Request $request)
    {

        $request->validate([
            'logo_dark'  => ['nullable', 'image', 'max:2048', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'logo'       => ['nullable', 'image', 'max:2048', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'logo_email' => ['nullable', 'image', 'max:2048', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'favicon'    => ['nullable', 'image', 'max:1024', new FileTypeValidate(['png'])],
        ]);

        try {
            $relPath = getFilePath('logoIcon');
            $path = public_path($relPath);

            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }

            $manager = new ImageManager(new Driver());

            /*
            | Each asset is written to a fixed filename, so a replacement overwrites
            | the old file in place and no orphans are left behind to clean up.
            */
            if ($request->hasFile('logo_dark')) {
                $manager->read($request->file('logo_dark'))->save($path . '/logo_dark.png');
            }

            if ($request->hasFile('logo')) {
                $manager->read($request->file('logo'))->save($path . '/logo.png');
            }

            if ($request->hasFile('logo_email')) {
                $manager->read($request->file('logo_email'))->save($path . '/logo_email.png');
            }

            if ($request->hasFile('favicon')) {
                $size = explode('x', getFileSize('favicon'));

                $manager->read($request->file('favicon'))
                    ->resize((int) $size[0], (int) $size[1])
                    ->save($path . '/favicon.png');
            }

            // Logo paths are read through gs()/asset(), but clear the settings cache
            // anyway so anything derived from it is rebuilt on the next request.
            \Illuminate\Support\Facades\Cache::forget('GeneralSetting');
            \Illuminate\Support\Facades\Artisan::call('view:clear');

            $notify[] = ['success', 'Logo & favicon updated successfully'];
        } catch (\Exception $exp) {
            $notify[] = ['error', 'Couldn\'t upload the images: ' . $exp->getMessage()];
        }

        return back()->withNotify($notify);
    }

    public function customCss()
    {
        $file = 'assets/web/css/custom.css';
        $fileContent = @file_get_contents($file);
        return view('admin.setting.custom_css', compact('fileContent'));
    }

    public function customCssSubmit(Request $request)
    {
        $file = 'assets/web/css/custom.css';
        if (!file_exists($file)) {
            fopen($file, "w");
        }
        file_put_contents($file, $request->css);
        $notify[] = ['success', 'CSS updated successfully'];
        return back()->withNotify($notify);
    }

    public function maintenanceMode()
    {
        $maintenance = Frontend::where('data_keys', 'maintenance.data')->firstOrFail();
        return view('admin.setting.maintenance', compact('maintenance'));
    }

    public function maintenanceModeSubmit(Request $request)
    {
        $request->validate([
            'description' => 'required',
        ]);
        $general = GeneralSetting::first();
        $general->maintenance_mode = $request->status ? Status::ENABLE : Status::DISABLE;
        $general->save();

        $maintenance = Frontend::where('data_keys', 'maintenance.data')->firstOrFail();
        $maintenance->data_values = [
            'description' => $request->description,
        ];
        $maintenance->save();

        $notify[] = ['success', 'Maintenance mode updated successfully'];
        return back()->withNotify($notify);
    }

    public function cookie()
    {
        $cookie = Frontend::where('data_keys', 'cookie.data')->firstOrFail();
        return view('admin.setting.cookie', compact('cookie'));
    }

    public function cookieSubmit(Request $request)
    {
        $request->validate([
            'short_desc' => 'required|string|max:255',
            'description' => 'required',
        ]);
        $cookie = Frontend::where('data_keys', 'cookie.data')->firstOrFail();
        $cookie->data_values = [
            'short_desc' => $request->short_desc,
            'description' => $request->description,
            'status' => $request->status ? Status::ENABLE : Status::DISABLE,
        ];
        $cookie->save();
        $notify[] = ['success', 'Cookie policy updated successfully'];
        return back()->withNotify($notify);
    }

    public function robots()
    {
        $pageTitle = 'Robots.txt Configuration';
        $filePath = public_path('robots.txt');
        if (file_exists($filePath)) {
            $fileContent = file_get_contents($filePath);
        } else {
            $fileContent = implode("\n", [
                'User-agent: *',
                'Disallow: /admin/',
                'Disallow: /user/',
                'Disallow: /api/',
                'Disallow: /clear',
                'Disallow: /change/',
                'Allow: /',
                '',
                'Sitemap: ' . url('sitemap.xml'),
            ]);
        }
        return view('admin.setting.robots', compact('fileContent', 'pageTitle'));
    }

    public function robotsSubmit(Request $request)
    {
        $request->validate([
            'robots' => 'required|string',
        ]);

        $filePath = public_path('robots.txt');
        file_put_contents($filePath, $request->robots);

        $notify[] = ['success', 'Robots.txt updated successfully'];
        return back()->withNotify($notify);
    }

    public function sitemap()
    {
        $pageTitle = 'XML Sitemap Manager';
        $urls = $this->getSitemapData();
        return view('admin.setting.sitemap', compact('urls', 'pageTitle'));
    }

    public function sitemapRefresh()
    {
        Cache::forget('sitemap.urls');
        $this->getSitemapData();
        $notify[] = ['success', 'Sitemap regenerated and cache cleared successfully'];
        return back()->withNotify($notify);
    }

    public function getSitemapData()
    {
        return Cache::remember('sitemap.urls', now()->addHour(), function () {
            $urls = [];

            // Primary Routes
            $staticRoutes = [
                ['loc' => url('/'), 'priority' => '1.0', 'changefreq' => 'daily', 'type' => 'Home Page'],
                ['loc' => url('services'), 'priority' => '0.9', 'changefreq' => 'weekly', 'type' => 'Our Services'],
                ['loc' => url('about-us'), 'priority' => '0.8', 'changefreq' => 'monthly', 'type' => 'About Us'],
                ['loc' => url('get-quote'), 'priority' => '0.8', 'changefreq' => 'weekly', 'type' => 'Get a Quote'],
                ['loc' => url('contact'), 'priority' => '0.7', 'changefreq' => 'monthly', 'type' => 'Contact Us'],
                ['loc' => url('privacy-policy'), 'priority' => '0.3', 'changefreq' => 'yearly', 'type' => 'Privacy Policy'],
                ['loc' => url('cookie-policy'), 'priority' => '0.3', 'changefreq' => 'yearly', 'type' => 'Cookie Policy'],
            ];

            foreach ($staticRoutes as $r) {
                $urls[] = [
                    'loc'        => $r['loc'],
                    'lastmod'    => now()->format('Y-m-d'),
                    'priority'   => $r['priority'],
                    'changefreq' => $r['changefreq'],
                    'type'       => $r['type'],
                ];
            }

            // Healthcare Services
            if (class_exists(HealthcareService::class)) {
                $services = HealthcareService::active()->get();
                foreach ($services as $svc) {
                    $urls[] = [
                        'loc'        => url('services#' . $svc->slug),
                        'lastmod'    => $svc->updated_at ? $svc->updated_at->format('Y-m-d') : now()->format('Y-m-d'),
                        'priority'   => '0.8',
                        'changefreq' => 'weekly',
                        'type'       => 'Service: ' . $svc->title,
                    ];
                }
            }

            // Projects / Case Studies
            if (class_exists(Project::class)) {
                $projects = Project::all();
                foreach ($projects as $proj) {
                    $urls[] = [
                        'loc'        => url('/#our-work'),
                        'lastmod'    => $proj->updated_at ? $proj->updated_at->format('Y-m-d') : now()->format('Y-m-d'),
                        'priority'   => '0.6',
                        'changefreq' => 'monthly',
                        'type'       => 'Project: ' . $proj->title,
                    ];
                }
            }

            // Custom Pages from Page Builder
            foreach (Page::where('slug', '!=', '/')->get(['slug', 'name', 'updated_at']) as $page) {
                $urls[] = [
                    'loc'        => url($page->slug),
                    'lastmod'    => $page->updated_at ? $page->updated_at->format('Y-m-d') : now()->format('Y-m-d'),
                    'priority'   => '0.6',
                    'changefreq' => 'monthly',
                    'type'       => 'Page: ' . $page->name,
                ];
            }

            // De-duplicate by 'loc'
            $unique = [];
            foreach ($urls as $u) {
                $unique[$u['loc']] = $u;
            }

            return array_values($unique);
        });
    }
}
