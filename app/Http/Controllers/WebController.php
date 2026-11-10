<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Models\Blog;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Page;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

class WebController extends Controller
{
    public function index()
    {
        $sections = Page::where('slug', '/')->first();
        $sectors = collect();

        return view('web.home', compact('sections', 'sectors'));
    }

    public function getQuote()
    {
        $page = Page::where('slug', 'get-quote')->first();
        $sections = $page ? $page->secs : json_encode(['get_quote']);
        $title = 'Get a Quote - Fast Healthcare Digital Estimate';

        return view('pages', compact('sections', 'title'));
    }

    public function submitQuote(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:120',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:120',
            'category' => 'nullable|string|max:120',
            'client_type' => 'nullable|string|max:120',
            'services' => 'nullable|array',
            'description' => 'nullable|string|max:4000',
            'message' => 'nullable|string|max:4000',
        ]);

        $category = $request->category ?? $request->client_type ?? 'General Practice';
        $message = $request->description ?? $request->message ?? 'Quote requested from /get-quote';

        $quote = \App\Models\QuoteRequest::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'client_type' => $category,
            'services' => $request->services ?? [],
            'message' => $message,
            'status' => 'pending',
            'ip_address' => $request->ip(),
        ]);

        try {
            $adminNotification = new \App\Models\AdminNotification();
            $adminNotification->user_id = 0;
            $adminNotification->title = 'New healthcare quote request from ' . $request->name;
            $adminNotification->click_url = urlPath('admin.quote_request.detail', $quote->id);
            $adminNotification->save();
        } catch (\Throwable $e) {
            // Notification is best-effort
        }

        return response()->json([
            'success' => true,
            'message' => 'Thank you! Your quote request has been received. Our healthcare digital team will contact you shortly.'
        ]);
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) {
            $lang = 'en';
        }

        session()->put('lang', $lang);

        return back();
    }

    public function cookieAccept()
    {
        Cookie::queue('gdpr_cookie', gs('site_name'), 43200);
    }

    public function cookiePolicy()
    {
        $cookie = Frontend::where('data_keys', 'cookie.data')->first();
        return view('cookie', compact('cookie'));
    }

    public function robots()
    {
        $filePath = public_path('robots.txt');
        if (file_exists($filePath)) {
            $content = file_get_contents($filePath);
        } else {
            $lines = [
                'User-agent: *',
                'Disallow: /admin/',
                'Disallow: /user/',
                'Disallow: /api/',
                'Disallow: /clear',
                'Disallow: /change/',
                'Allow: /',
                '',
                'Sitemap: ' . url('sitemap.xml'),
            ];
            $content = implode("\n", $lines);
        }

        return response($content, 200)->header('Content-Type', 'text/plain');
    }

    public function sitemap()
    {
        $generalSetting = new \App\Http\Controllers\Admin\GeneralSettingController();
        $urls = $generalSetting->getSitemapData();

        return response()->view('sitemap', compact('urls'))->header('Content-Type', 'application/xml');
    }

    public function pages($slug)
    {
        $page = Page::where('slug', $slug)
            ->orWhere(function ($q) use ($slug) {
                if ($slug === 'about-us') {
                    $q->where('slug', 'about');
                } elseif ($slug === 'about') {
                    $q->where('slug', 'about-us');
                }
            })
            ->firstOrFail();

        $title = $page->name;
        $sections = $page->secs;

        return view('pages', compact('title', 'sections'));
    }

    public function privacyPolicy()
    {
        $policy = Frontend::where('data_keys', 'policy_pages.element')->where('id', 42)->first()
            ?? Frontend::where('data_keys', 'policy_pages.element')->first();

        $title = @$policy->data_values->title ?? 'Privacy Policy';
        return view('policy', compact('policy', 'title'));
    }

    public function policyPages($slug = null, $id = null)
    {
        if ($id) {
            $policy = Frontend::where('id', $id)->where('data_keys', 'policy_pages.element')->first();
        } else {
            $policy = Frontend::where('data_keys', 'policy_pages.element')->where('id', 42)->first()
                ?? Frontend::where('data_keys', 'policy_pages.element')->first();
        }

        if (!$policy) {
            abort(404);
        }

        $title = @$policy->data_values->title ?? 'Policy';
        return view('policy', compact('policy', 'title'));
    }

    public function maintenance()
    {
        if (gs('maintenance_mode') == Status::DISABLE) {
            return to_route('home');
        }
        $maintenance = Frontend::where('data_keys', 'maintenance.data')->first();
        return view('maintenance', compact('maintenance'));
    }

    public function subscribe(Request $request)
    {
        $rules = [
            'email' => 'required|email|unique:subscribers,email',
        ];
        $message = [
            'email.unique' => 'You have already subscribed',
        ];
        $validator = validator()->make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->getMessages()]);
        }

        $subscribe = new Subscriber();
        $subscribe->email = $request->email;
        $subscribe->save();

        return response()->json(['success' => true, 'message' => 'Thanks for subscribe']);
    }

    public function blogs()
    {
        $blogs = Blog::active()->paginate(getPaginate());
        $sections = Page::where('slug', 'blogs')->first();

        return view('web.blogs', compact('blogs', 'sections'));
    }

    public function blogDetails($slug)
    {
        $blog = Blog::active()->where('slug', $slug)->firstOrFail();

        $blog->view = $blog->view + 1;
        $blog->save();

        $recentPosts = Blog::active()->where('id', '!=', $blog->id)->orderBy('id', 'desc')->limit(5)->get();
        $popularPosts = Blog::active()->where('id', '!=', $blog->id)->orderBy('view', 'desc')->limit(5)->get();

        return view('web.blog_details', compact('blog', 'recentPosts', 'popularPosts'));
    }
}
