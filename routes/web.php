<?php

use App\Http\Controllers\AssistantController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\WebRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    return back();
});


/*
| AI Help Center.
|
| Must stay above the WebController group - that group ends with the catch-all
| `/{slug}` page route, and anything declared after it is unreachable.
|
| Throttled per IP: this endpoint costs money per call, so it is the one public
| route on the site where an unmetered scraper would show up on the invoice.
*/
Route::controller(AssistantController::class)
    ->middleware('throttle:' . (int) config('assistant.limits.per_minute', 8) . ',1')
    ->group(function () {
        Route::get('/ask', 'answer')->name('assistant.answer');
        Route::post('/ask', 'ask')->name('assistant.ask');
        Route::post('/ask/feedback', 'feedback')->name('assistant.feedback');
    });



// User Support Ticket
Route::controller(SupportController::class)->prefix('support')->name('support.')->group(function () {
    Route::get('/all', 'supportTicket')->name('index');
    Route::get('new', 'openSupport')->name('open');
    Route::post('create', 'storeSupport')->name('store');
    Route::get('view/{number}', 'viewSupport')->name('view');
    Route::post('reply/{number}', 'replySupport')->name('reply');
    Route::post('close/{number}', 'closeSupport')->name('close');
    Route::get('download/{number}', 'supportDownload')->name('download');
});


Route::controller(WebController::class)->group(function () {

   //web
    Route::get('maintenance-mode', 'maintenance')->name('maintenance');
    Route::get('robots.txt', 'robots')->name('robots');
    Route::get('sitemap.xml', 'sitemap')->name('sitemap');
    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');
    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');
    Route::get('privacy-policy', 'privacyPolicy')->name('privacy.policy');
    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');
    Route::post('subscribe', 'subscribe')->name('subscribe');
    Route::get('get-quote', 'getQuote')->name('get.quote');
    Route::post('quote/submit', 'submitQuote')->name('quote.submit');
    Route::get('policy/{slug?}/{id?}', 'policyPages')->name('policy.pages');
    Route::get('/{slug}', 'pages')->name('pages');
    Route::get('/', 'index')->name('home');
});


require __DIR__ . '/auth.php';
