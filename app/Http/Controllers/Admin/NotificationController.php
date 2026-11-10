<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NotificationTemplate;

class NotificationController extends Controller
{
    public function global()
    {
        return view('admin.notification.global_template');
    }

    public function globalUpdate(Request $request)
    {
        $request->validate([
            'email_from' => 'required|email|string|max:40',
            'sms_from' => 'required|string|max:40',
            'email_template' => 'required',
            'sms_body' => 'required',
        ]);

        $general = gs();
        $general->email_from = $request->email_from;
        $general->email_template = $request->email_template;
        $general->sms_from = $request->sms_from;
        $general->sms_body = $request->sms_body;
        $general->save();

        $notify[] = ['success', 'Global notification settings updated successfully'];
        return back()->withNotify($notify);
    }

    public function templates()
    {
        $templates = NotificationTemplate::orderBy('name')->get();
        return view('admin.notification.templates', compact('templates'));
    }

    public function templateEdit($id)
    {
        $template = NotificationTemplate::findOrFail($id);
        return view('admin.notification.edit', compact('template'));
    }

    public function templateUpdate(Request $request, $id)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'email_body' => 'required',
            'sms_body' => 'required',
        ]);
        $template = NotificationTemplate::findOrFail($id);
        $template->subj = $request->subject;
        $template->email_body = $request->email_body;
        $template->email_status = $request->email_status ? Status::ENABLE : Status::DISABLE;
        $template->sms_body = $request->sms_body;
        $template->sms_status = $request->sms_status ? Status::ENABLE : Status::DISABLE;
        $template->save();

        $notify[] = ['success', 'Notification template updated successfully'];
        return back()->withNotify($notify);
    }

    public function emailSetting()
    {
        return view('admin.notification.email_setting');
    }

    public function emailSettingUpdate(Request $request)
    {
        $request->validate([
            'email_method' => 'required|in:php,smtp,sendgrid,mailjet',
            'host' => 'required_if:email_method,smtp|nullable|string|max:191',
            'port' => 'required_if:email_method,smtp|nullable|integer|between:1,65535',
            'username' => 'required_if:email_method,smtp|nullable|string|max:191',
            // Left blank means "keep the stored password", so it is never required here.
            'password' => 'nullable|string|max:191',
            'enc' => 'required_if:email_method,smtp|nullable|in:ssl,tls',
            'appkey' => 'required_if:email_method,sendgrid|nullable|string|max:255',
            'public_key' => 'required_if:email_method,mailjet|nullable|string|max:255',
            'secret_key' => 'required_if:email_method,mailjet|nullable|string|max:255',

            'email_from' => 'required|email|max:191',
            'email_from_name' => 'required|string|max:191',
            'email_reply_to' => 'nullable|email|max:191',
            'email_signature' => 'nullable|string|max:5000',
            'email_signature_ar' => 'nullable|string|max:5000',
        ], [
            'host.required_if' => ':attribute is required for SMTP configuration',
            'port.required_if' => ':attribute is required for SMTP configuration',
            'port.integer' => ':attribute must be a port number',
            'username.required_if' => ':attribute is required for SMTP configuration',
            'enc.required_if' => ':attribute is required for SMTP configuration',
            'appkey.required_if' => ':attribute is required for SendGrid configuration',
            'public_key.required_if' => ':attribute is required for Mailjet configuration',
            'secret_key.required_if' => ':attribute is required for Mailjet configuration',
        ]);

        $general = gs();
        $current = (array) ($general->mail_config ?? []);

        /*
        | Secrets are never rendered back into the form, so an empty field means
        | "unchanged". Only overwrite one when the admin actually typed something.
        */
        $keepSecret = function ($input, $key) use ($request, $current) {
            $value = $request->input($input);
            return ($value === null || $value === '') ? ($current[$key] ?? null) : $value;
        };

        if ($request->email_method == 'php') {
            $data = ['name' => 'php'];
        } elseif ($request->email_method == 'smtp') {
            $data = [
                'name' => 'smtp',
                'host' => $request->host,
                'port' => (string) $request->port,
                'enc' => $request->enc,
                'username' => $request->username,
                'password' => $keepSecret('password', 'password'),
            ];
        } elseif ($request->email_method == 'sendgrid') {
            $data = [
                'name' => 'sendgrid',
                'appkey' => $keepSecret('appkey', 'appkey'),
            ];
        } else {
            $data = [
                'name' => 'mailjet',
                'public_key' => $keepSecret('public_key', 'public_key'),
                'secret_key' => $keepSecret('secret_key', 'secret_key'),
            ];
        }

        $general->mail_config = $data;
        $general->email_from = $request->email_from;
        $general->email_from_name = $request->email_from_name;
        $general->email_reply_to = $request->email_reply_to;
        $general->email_signature = $request->email_signature;
        $general->email_signature_ar = $request->email_signature_ar;
        $general->save();

        $notify[] = ['success', 'Email settings updated successfully'];
        return back()->withNotify($notify);
    }

    public function emailTest(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $general = gs();
        $config = $general->mail_config;

        if (!$general->en) {
            $notify[] = ['info', 'Please enable from general settings'];
            $notify[] = ['error', 'Your email notification is disabled'];

            return back()->withNotify($notify);
        }

        $subject = strtoupper($config->name) . ' Configuration Test';
        $message = 'Your email notification setting is configured successfully for ' . $general->site_name;

        /*
        | Send straight through the configured transport instead of notify().
        | notify() needs a NotificationTemplate row and returns silently when one
        | is missing, so this screen used to report success without sending
        | anything - including when the SMTP host was wrong.
        */
        try {
            (new \App\Notify\Email())->sendDirect($request->email, $subject, $message);

            $notify[] = ['success', 'Email sent to ' . $request->email . ' successfully'];
        } catch (\Throwable $e) {
            $notify[] = ['error', 'Sending failed: ' . $e->getMessage()];
        }

        return back()->withNotify($notify);
    }

    public function smsSetting()
    {
        return view('admin.notification.sms_setting');
    }

    public function smsSettingUpdate(Request $request)
    {
        $request->validate([
            'sms_method' => 'required|in:clickatell,infobip,messageBird,nexmo,smsBroadcast,twilio,textMagic,custom',
            'clickatell_api_key' => 'required_if:sms_method,clickatell',
            'message_bird_api_key' => 'required_if:sms_method,messageBird',
            'nexmo_api_key' => 'required_if:sms_method,nexmo',
            'nexmo_api_secret' => 'required_if:sms_method,nexmo',
            'infobip_username' => 'required_if:sms_method,infobip',
            'infobip_password' => 'required_if:sms_method,infobip',
            'sms_broadcast_username' => 'required_if:sms_method,smsBroadcast',
            'sms_broadcast_password' => 'required_if:sms_method,smsBroadcast',
            'text_magic_username' => 'required_if:sms_method,textMagic',
            'apiv2_key' => 'required_if:sms_method,textMagic',
            'account_sid' => 'required_if:sms_method,twilio',
            'auth_token' => 'required_if:sms_method,twilio',
            'from' => 'required_if:sms_method,twilio',
            'custom_api_method' => 'required_if:sms_method,custom|in:get,post',
            'custom_api_url' => 'required_if:sms_method,custom',
        ]);

        $data = [
            'name' => $request->sms_method,
            'clickatell' => [
                'api_key' => $request->clickatell_api_key,
            ],
            'infobip' => [
                'username' => $request->infobip_username,
                'password' => $request->infobip_password,
            ],
            'message_bird' => [
                'api_key' => $request->message_bird_api_key,
            ],
            'nexmo' => [
                'api_key' => $request->nexmo_api_key,
                'api_secret' => $request->nexmo_api_secret,
            ],
            'sms_broadcast' => [
                'username' => $request->sms_broadcast_username,
                'password' => $request->sms_broadcast_password,
            ],
            'twilio' => [
                'account_sid' => $request->account_sid,
                'auth_token' => $request->auth_token,
                'from' => $request->from,
            ],
            'text_magic' => [
                'username' => $request->text_magic_username,
                'apiv2_key' => $request->apiv2_key,
            ],
            'custom' => [
                'method' => $request->custom_api_method,
                'url' => $request->custom_api_url,
                'headers' => [
                    'name' => $request->custom_header_name ?? [],
                    'value' => $request->custom_header_value ?? [],
                ],
                'body' => [
                    'name' => $request->custom_body_name ?? [],
                    'value' => $request->custom_body_value ?? [],
                ],
            ],
        ];
        $general = gs();
        $general->sms_config = $data;
        $general->save();
        $notify[] = ['success', 'Sms settings updated successfully'];
        return back()->withNotify($notify);
    }

    public function smsTest(Request $request)
    {
        $request->validate(['mobile' => 'required']);
        $general = gs();
        if ($general->sn == 1) {
            $sendSms = new Sms;
            $sendSms->mobile = $request->mobile;
            $sendSms->receiverName = ' ';
            $sendSms->message = 'Your sms notification setting is configured successfully for ' . $general->site_name;
            $sendSms->subject = ' ';
            $sendSms->send();
        } else {
            $notify[] = ['info', 'Please enable from general settings'];
            $notify[] = ['error', 'Your sms notification is disabled'];
            return back()->withNotify($notify);
        }

        if (session('sms_error')) {
            $notify[] = ['error', session('sms_error')];
        } else {
            $notify[] = ['success', 'SMS sent to ' . $request->mobile . 'successfully'];
        }

        return back()->withNotify($notify);
    }

}
