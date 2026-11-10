<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Language;
use App\Constants\Status;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LanguageMiddleware
{

    public function handle($request, Closure $next)
    {
        $code = $this->getCode();
        session()->put('lang', $code);
        app()->setLocale($code);
        return $next($request);
    }

    public function getCode()
    {
        if (session()->has('lang')) {
            return session('lang');
        }

        $language = Language::where('is_default', Status::ENABLE)->first();

        return $language ? $language->code : 'en';
    }
}
