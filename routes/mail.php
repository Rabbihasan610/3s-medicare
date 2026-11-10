<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mail\SMSController;
use App\Http\Controllers\Mail\ContactController;
use App\Http\Controllers\Mail\SettingController;
use App\Http\Controllers\Mail\CategoryController;
use App\Http\Controllers\Mail\SendMailController;
use App\Http\Controllers\Mail\TemplateController;
use App\Http\Controllers\Mail\SmsConfigController;
use App\Http\Controllers\Mail\DomainConfigController;
use App\Http\Controllers\Mail\MailGlobalController;



Route::group(['prefix' => 'contacts', 'as' => 'contacts.'], function(){
    Route::get('sms', [ContactController::class, 'index'])->name('sms.index');
    Route::get('mail', [ContactController::class, 'mail'])->name('email.index');
    Route::post('store', [ContactController::class, 'store'])->name('store');
    Route::get('create', [ContactController::class, 'create'])->name('create');
    Route::post('import-file', [ContactController::class, 'contactBulkUpload'])->name('contactBulkUpload');
});

Route::group(['prefix' => 'send-mail', 'as' => 'send-mail.', 'controller' => SendMailController::class], function (){
    Route::get('/', 'index')->name('index');
    Route::get('/group/sendmail', 'indexsendmail')->name('group');
    Route::get('send-email/{id}', 'sendEmail')->name('send.email');
    Route::get('send-sms/{id}', 'sendSMS')->name('send.sms');
    Route::get('history','mailhistory')->name('mail.history');
});

Route::group(['prefix' => 'template', 'as' => 'template.', 'controller' => TemplateController::class], function (){
    Route::get('/', 'index')->name('index');
    Route::get('edit/{id}', 'edit')->name('edit');
    Route::post('update/{id}', 'update')->name('update');
});

Route::resource('category', CategoryController::class);

Route::get('messaging/sendmessage',[SMSController::class,'index'])->name('messaging.sendmessage');
Route::get('general-messaging/sendmessage',[SMSController::class,'general'])->name('general-messaging.sendmessage');
Route::get('group/messaging/sendmessage',[SMSController::class,'groupsms'])->name('group.messaging.sendmessage');
Route::get('sms/history',[SMSController::class,'smshistory'])->name('sms.history');

// store message

Route::post('send-message',[SMSController::class,'store'])->name('sms.sendmessage');
Route::post('send-general-message',[SMSController::class,'sendGeneralMessage'])->name('sms.send.general.message');
Route::post('send-group-message',[SMSController::class,'sendGroupMessage'])->name('sms.send.group.message');


Route::post('send-mail',[SendMailController::class,'store'])->name('mail.sendmail');
Route::post('send-general-mail',[SendMailController::class,'sendGeneralMail'])->name('mail.send.general.mail');
Route::post('send-group-mail',[SendMailController::class,'sendGroupMail'])->name('mail.send.group.mail');


Route::resource('domainconfig',DomainConfigController::class);
Route::resource('smsconfig',SmsConfigController::class);


Route::prefix('setting')->name('setting.')->group(function () {
    Route::get('/sms', [SettingController::class, 'sms'])->name('sms');
    Route::get('edit-sms/{id}', [SettingController::class, 'editSms'])->name('edit.sms');
    Route::post('sms-update/{id}', [SettingController::class, 'smsUpdate'])->name('store.sms');
    Route::get('/email', [SettingController::class, 'email'])->name('email');
    Route::get('/create-email', [SettingController::class, 'createEmail'])->name('createEmail');
    Route::post('/store-email', [SettingController::class, 'storeEmail'])->name('storeEmail');
    Route::get('edit-email/{id}', [SettingController::class, 'editEmail'])->name('edit.email');
    Route::post('email-update/{id}', [SettingController::class, 'emailUpdate'])->name('store.email');
});

Route::get('demo/csv/file', [MailGlobalController::class, 'demoImportFilesms'])->name('demo.csv.downlode');
Route::get('demo/exel/download/{extension}', [MailGlobalController::class, 'demoFileDownloader'])->name('demo.exel.downlode');
