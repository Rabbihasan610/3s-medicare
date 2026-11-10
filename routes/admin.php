<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\ExtensionController;
use App\Http\Controllers\Admin\FrontendController;
use App\Http\Controllers\Admin\HealthcareServiceController;
use App\Http\Controllers\Admin\GeneralSettingController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\ManageUsersController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PageBuilderController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\QuoteRequestController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RequestOrderController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\SupportTicketController;
use App\Http\Controllers\Admin\Assistant\ConversationController as AssistantConversationController;
use App\Http\Controllers\Admin\Assistant\InsightController as AssistantInsightController;
use App\Http\Controllers\Admin\Assistant\KnowledgeController as AssistantKnowledgeController;
use App\Http\Controllers\Admin\Assistant\ProviderController as AssistantProviderController;
use App\Http\Controllers\Admin\Assistant\QueryController as AssistantQueryController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'Login']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

//     Admin Password Reset
Route::prefix('password')->name('password.')->group(function () {
    Route::get('reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('reset');
    Route::post('reset', [ForgotPasswordController::class, 'sendResetCodeEmail']);
    Route::get('code-verify', [ForgotPasswordController::class, 'codeVerify'])->name('code.verify');
    Route::post('verify-code', [ForgotPasswordController::class, 'verifyCode'])->name('verify.code');
});

Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset.form');
Route::post('password/reset/change', [ResetPasswordController::class, 'reset'])->name('password.change');

Route::middleware('admin')->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('profile', [AdminController::class, 'profile'])->name('profile');
    Route::post('profile', [AdminController::class, 'profileUpdate'])->name('profile.update');
    Route::get('password', [AdminController::class, 'password'])->name('password');
    Route::post('password', [AdminController::class, 'passwordUpdate'])->name('password.update');

    //Notification
    Route::get('notifications', [AdminController::class, 'notifications'])->name('notifications');
    Route::get('notification/read/{id}', [AdminController::class, 'notificationRead'])->name('notification.read');
    Route::get('notifications/read-all', [AdminController::class, 'readAll'])->name('notifications.readAll');

    // Users Manager
    Route::name('users.')->prefix('users')->group(function () {
        Route::get('/', [ManageUsersController::class, 'allUsers'])->name('all');
        Route::get('active', [ManageUsersController::class, 'activeUsers'])->name('active');
        Route::get('banned', [ManageUsersController::class, 'bannedUsers'])->name('banned');
        Route::get('email-verified', [ManageUsersController::class, 'emailVerifiedUsers'])->name('email.verified');
        Route::get('email-unverified', [ManageUsersController::class, 'emailUnverifiedUsers'])->name('email.unverified');
        Route::get('mobile-unverified', [ManageUsersController::class, 'mobileUnverifiedUsers'])->name('mobile.unverified');
        Route::get('detail/{id}', [ManageUsersController::class, 'detail'])->name('detail');
        Route::post('update/{id}', [ManageUsersController::class, 'update'])->name('update');
        Route::get('send-notification/{id}', [ManageUsersController::class, 'showNotificationSingleForm'])->name('notification.single');
        Route::post('send-notification/{id}', [ManageUsersController::class, 'sendNotificationSingle'])->name('notification.single');
        Route::get('login/{id}', [ManageUsersController::class, 'login'])->name('login');
        Route::post('status/{id}', [ManageUsersController::class, 'status'])->name('status');

        Route::get('send-notification', [ManageUsersController::class, 'showNotificationAllForm'])->name('notification.all');
        Route::post('send-notification', [ManageUsersController::class, 'sendNotificationAll'])->name('notification.all.send');
        Route::get('list', [ManageUsersController::class, 'list'])->name('list');
        Route::get('notification-log/{id}', [ManageUsersController::class, 'notificationLog'])->name('notification.log');
        Route::get('user-export-excel', [ManageUsersController::class, 'exportExcel'])->name('export.excel');
    });

    // Admin Support
    Route::prefix('support')->name('support.')->group(function () {
        Route::get('/', [SupportTicketController::class, 'tickets'])->name('index');
        Route::get('pending', [SupportTicketController::class, 'pendingTicket'])->name('pending');
        Route::get('closed', [SupportTicketController::class, 'closedTicket'])->name('closed');
        Route::get('answered', [SupportTicketController::class, 'answeredTicket'])->name('answered');
        Route::get('view/{id}', [SupportTicketController::class, 'ticketReply'])->name('view');
        Route::post('reply/{id}', [SupportTicketController::class, 'replyTicket'])->name('reply');
        Route::post('close/{id}', [SupportTicketController::class, 'closeTicket'])->name('close');
        Route::get('download/{ticket}', [SupportTicketController::class, 'ticketDownload'])->name('download');
        Route::post('delete/{id}', [SupportTicketController::class, 'ticketDelete'])->name('delete');
    });

    // Report
    Route::prefix('report')->name('report.')->group(function () {
        Route::get('login/history', [ReportController::class, 'loginHistory'])->name('login.history');
        Route::get('login/ipHistory/{ip}', [ReportController::class, 'loginIpHistory'])->name('login.ipHistory');
        Route::get('notification/history', [ReportController::class, 'notificationHistory'])->name('notification.history');
        Route::get('email/detail/{id}', [ReportController::class, 'emailDetails'])->name('email.details');
    });

    // Subscriber
    Route::prefix('subscriber')->name('subscriber.')->group(function () {
        Route::get('/', [SubscriberController::class, 'index'])->name('index');
        Route::get('send-email', [SubscriberController::class, 'sendEmailForm'])->name('send.email');
        Route::post('remove/{id}', [SubscriberController::class, 'remove'])->name('remove');
        Route::post('send-email', [SubscriberController::class, 'sendEmail'])->name('send.email');
    });

    // General Setting
    Route::get('general-setting', [GeneralSettingController::class, 'index'])->name('setting.index');
    Route::post('general-setting', [GeneralSettingController::class, 'update'])->name('setting.update');

    //configuration
    Route::get('setting/system-configuration', [GeneralSettingController::class, 'systemConfiguration'])->name('setting.system.configuration');
    Route::post('setting/system-configuration', [GeneralSettingController::class, 'systemConfigurationSubmit']);

    // Logo-Icon
    Route::get('setting/logo-icon', [GeneralSettingController::class, 'logoIcon'])->name('setting.logo.icon');
    Route::post('setting/logo-icon', [GeneralSettingController::class, 'logoIconUpdate'])->name('setting.logo.icon');

    // Robots.txt
    Route::get('setting/robots', [GeneralSettingController::class, 'robots'])->name('setting.robots');
    Route::post('setting/robots', [GeneralSettingController::class, 'robotsSubmit']);

    // Sitemap
    Route::get('setting/sitemap', [GeneralSettingController::class, 'sitemap'])->name('setting.sitemap');
    Route::post('setting/sitemap/refresh', [GeneralSettingController::class, 'sitemapRefresh'])->name('setting.sitemap.refresh');

    //Custom CSS
    Route::get('custom-css', [GeneralSettingController::class, 'customCss'])->name('setting.custom.css');
    Route::post('custom-css', [GeneralSettingController::class, 'customCssSubmit']);

    //Cookie
    Route::get('cookie', [GeneralSettingController::class, 'cookie'])->name('setting.cookie');
    Route::post('cookie', [GeneralSettingController::class, 'cookieSubmit']);

    //maintenance_mode
    Route::get('maintenance-mode', [GeneralSettingController::class, 'maintenanceMode'])->name('maintenance.mode');
    Route::post('maintenance-mode', [GeneralSettingController::class, 'maintenanceModeSubmit']);

    // Plugin
    Route::prefix('extensions')->name('extensions.')->group(function () {
        Route::get('/', [ExtensionController::class, 'index'])->name('index');
        Route::post('update/{id}', [ExtensionController::class, 'update'])->name('update');
        Route::post('status/{id}', [ExtensionController::class, 'status'])->name('status');
    });

    // Language Manager
    Route::prefix('language')->name('language.')->group(function () {
        Route::get('/', [LanguageController::class, 'langManage'])->name('manage');
        Route::post('/', [LanguageController::class, 'langStore'])->name('manage.store');
        Route::post('delete/{id}', [LanguageController::class, 'langDelete'])->name('manage.delete');
        Route::post('update/{id}', [LanguageController::class, 'langUpdate'])->name('manage.update');
        Route::get('edit/{id}', [LanguageController::class, 'langEdit'])->name('key');
        Route::post('import', [LanguageController::class, 'langImport'])->name('import.lang');
        Route::post('store/key/{id}', [LanguageController::class, 'storeLanguageJson'])->name('store.key');
        Route::post('delete/key/{id}', [LanguageController::class, 'deleteLanguageJson'])->name('delete.key');
        Route::post('update/key/{id}', [LanguageController::class, 'updateLanguageJson'])->name('update.key');
        Route::get('get-keys', [LanguageController::class, 'getKeys'])->name('get.key');
    });

    Route::get('seo', [FrontendController::class, 'seoEdit'])->name('seo');

    // Frontend
    Route::name('frontend.')->prefix('frontend')->group(function () {
        Route::get('frontend-sections/{key}', [FrontendController::class, 'frontendSections'])->name('sections');
        Route::post('frontend-content/{key}', [FrontendController::class, 'frontendContent'])->name('sections.content');
        Route::get('frontend-element/{key}/{id?}', [FrontendController::class, 'frontendElement'])->name('sections.element');
        Route::post('remove/{id}', [FrontendController::class, 'remove'])->name('remove');

        // Page Builder
        Route::get('manage-pages', [PageBuilderController::class, 'managePages'])->name('manage.pages');
        Route::post('manage-pages', [PageBuilderController::class, 'managePagesSave'])->name('manage.pages.save');
        Route::post('manage-pages/update', [PageBuilderController::class, 'managePagesUpdate'])->name('manage.pages.update');
        Route::post('manage-pages/delete/{id}', [PageBuilderController::class, 'managePagesDelete'])->name('manage.pages.delete');
        Route::get('manage-section/{id}', [PageBuilderController::class, 'manageSection'])->name('manage.section');
        Route::post('manage-section/{id}', [PageBuilderController::class, 'manageSectionUpdate'])->name('manage.section.update');
    });

    //Notification Setting
    Route::name('setting.notification.')->controller('NotificationController')->prefix('notification')->group(function () {
        //Template Setting
        Route::get('global', [NotificationController::class, 'global'])->name('global');
        Route::post('global/update', [NotificationController::class, 'globalUpdate'])->name('global.update');
        Route::get('templates', [NotificationController::class, 'templates'])->name('templates');
        Route::get('template/edit/{id}', [NotificationController::class, 'templateEdit'])->name('template.edit');
        Route::post('template/update/{id}', [NotificationController::class, 'templateUpdate'])->name('template.update');

        //Email Setting
        Route::get('email/setting', [NotificationController::class, 'emailSetting'])->name('email');
        Route::post('email/setting', [NotificationController::class, 'emailSettingUpdate']);
        Route::post('email/test', [NotificationController::class, 'emailTest'])->name('email.test');

        //SMS Setting
        Route::get('sms/setting', [NotificationController::class, 'smsSetting'])->name('sms');
        Route::post('sms/setting', [NotificationController::class, 'smsSettingUpdate']);
        Route::post('sms/test', [NotificationController::class, 'smsTest'])->name('sms.test');
    });



    // country route
    Route::prefix('country')->name('country.')->group(function () {
        Route::get('/', [CountryController::class, 'index'])->name('index');
        Route::post('/store/{id?}', [CountryController::class, 'store'])->name('store');
    });

});

Route::middleware('admin')->group(function () {

    // 3S Medi Care — Quote Requests & Leads
    Route::prefix('quote-requests')->name('quote_request.')->group(function () {
        Route::get('/', [QuoteRequestController::class, 'index'])->name('index');
        Route::get('/detail/{id}', [QuoteRequestController::class, 'detail'])->name('detail');
        Route::post('/update/{id}', [QuoteRequestController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [QuoteRequestController::class, 'destroy'])->name('delete');
    });

    // 3S Medi Care — Healthcare Services Catalog
    Route::prefix('services')->name('service.')->group(function () {
        Route::get('/', [HealthcareServiceController::class, 'index'])->name('index');
        Route::post('/store/{id?}', [HealthcareServiceController::class, 'store'])->name('store');
        Route::get('/status/{id}', [HealthcareServiceController::class, 'status'])->name('status');
        Route::post('/delete/{id}', [HealthcareServiceController::class, 'destroy'])->name('delete');
    });

    // 3S Medi Care — Case Studies & Projects
    Route::prefix('projects')->name('project.')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('index');
        Route::post('/store/{id?}', [ProjectController::class, 'store'])->name('store');
        Route::get('/featured/{id}', [ProjectController::class, 'featured'])->name('featured');
        Route::post('/delete/{id}', [ProjectController::class, 'destroy'])->name('delete');
    });

    Route::group(['prefix' => 'request-order'], function () {
        Route::get('/',  [RequestOrderController::class, 'index'])->name('request_order.index');
        Route::get('/show/{id}', [RequestOrderController::class, 'show'])->name('request_order.show');
        Route::post('/update/{id}', [RequestOrderController::class, 'update'])->name('request_order.update');
        Route::post('/status/{id}', [RequestOrderController::class, 'status'])->name('request_order.status');
        Route::post('/delete/{id}', [RequestOrderController::class, 'destroy'])->name('request_order.delete');
    });

    /*
    | AI Help Center.
    |
    | `assistant.*` rather than `ai.*` - admin.ai.* already belongs to the
    | AI & Data service request module and the two are unrelated.
    */
    Route::prefix('assistant')->name('assistant.')->group(function () {

        Route::get('/', [AssistantInsightController::class, 'index'])->name('insights');

        Route::prefix('providers')->name('providers.')->group(function () {
            Route::get('/', [AssistantProviderController::class, 'index'])->name('index');
            Route::get('/create', [AssistantProviderController::class, 'create'])->name('create');
            Route::post('/store', [AssistantProviderController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [AssistantProviderController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [AssistantProviderController::class, 'store'])->name('update');
            Route::post('/test/{id}', [AssistantProviderController::class, 'test'])->name('test');
            Route::post('/status/{id}', [AssistantProviderController::class, 'status'])->name('status');
            // POST, not DELETE: the shared <x-confirmation-modal /> submits a plain
            // POST form with no method spoofing.
            Route::post('/delete/{id}', [AssistantProviderController::class, 'destroy'])->name('destroy');
        });

        /*
        | Threads rather than single questions - whether a follow-up was
        | understood, and where a conversation gave up.
        */
        Route::prefix('conversations')->name('conversations.')->group(function () {
            Route::get('/', [AssistantConversationController::class, 'index'])->name('index');
            Route::get('/show/{id}', [AssistantConversationController::class, 'show'])->name('show');
            // POST, not DELETE: the shared <x-confirmation-modal /> submits a
            // plain POST form with no method spoofing.
            Route::post('/delete/{id}', [AssistantConversationController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('queries')->name('queries.')->group(function () {
            Route::get('/', [AssistantQueryController::class, 'index'])->name('index');
            Route::get('/unanswered', [AssistantQueryController::class, 'unanswered'])->name('unanswered');
            Route::get('/show/{id}', [AssistantQueryController::class, 'show'])->name('show');
            Route::post('/delete/{id}', [AssistantQueryController::class, 'destroy'])->name('destroy');
        });

        Route::get('/knowledge', [AssistantKnowledgeController::class, 'index'])->name('knowledge');
        Route::post('/knowledge/reindex', [AssistantKnowledgeController::class, 'reindex'])->name('knowledge.reindex');
    });
});
