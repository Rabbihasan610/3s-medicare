<?php
namespace App\Http\Controllers\Mail;

use App\Jobs\SendSmsJob;

use App\Traits\SmsTrait;
use App\Services\SmsService;
use Illuminate\Http\Request;
use App\Models\Mail\Category;
use App\Models\Mail\Template;
use App\Models\Mail\SmsConfig;
use App\Models\Mail\SmsHistory;
use App\Http\Controllers\Controller;

class SMSController extends Controller
{
    use SmsTrait;

    protected  $smsService;
    public function __construct(SmsService $smsService)
    {
        return $this->smsService = $smsService;
    }

    public function index()
    {
        $data['templates'] = Template::get();
        $data['providers'] = SmsConfig::Active()->get();
        return view('mail_vendor.sms.students',$data);
    }

    public function  general()
    {
        $data['templates'] = Template::get();
        $data['providers'] = SmsConfig::Active()->get();
        return view('mail_vendor.sms.general',$data);
    }


    public function groupsms()
    {
        $data['categories'] = Category::where('type','SMS')->get();
        $data['templates'] = Template::get();
        $data['providers'] = SmsConfig::Active()->get();

        return view('mail_vendor.sms.groupstudent',$data);
    }

    public function sendGeneralMessage(Request $request)
    {
        $request->validate([
            "provider"         => "required|exists:sms_configs,code",
            "phone"            => "required",
            "template"         => "nullable|exists:templates,code",
            "message"          => "required",
        ]);

        $phone_lists = [];

        if($request->input('phone')){
            $phones = $request->input('phone');
            $phone_lists = explode(',', $phones);
        }

        $history = $this->smsService->historySave($request, $phone_lists);

        if($history != false){
            dispatch(new SendSmsJob($history->id));
        }else{
            return back()->with('error', 'Message send fail');
        }

        return back()->with('success', 'Message send successfully');
    }


    public function store(Request $request)
    {
        $request->validate([
            "provider"         => "required|exists:sms_configs,code",
            "phone"            => "required",
            "template"         => "nullable|exists:templates,code",
            "message"          => "required",
        ]);

        $phone_lists = [];

        if($request->input('phone')){
            $phones = $request->input('phone');
            $phone_lists = explode(',', $phones);
        }


        $history = $this->smsService->historySave($request, $phone_lists);

        dispatch(new SendSmsJob($history->id));

        return back()->with('success', 'Message send successfully');
    }

    public function sendGroupMessage(Request $request)
    {

        $request->validate([
            "provider"         => "required|exists:sms_configs,code",
            "category_id"      => "required|exists:categories,id",
            "template"         => "nullable|exists:templates,code",
            "message"          => "required",
        ]);


        $history = $this->smsService->historySave($request);

        if($history != false){
            dispatch(new SendSmsJob($history->id));
        }else{
            return back()->with('error', 'Message send fail');
        }


        return back()->with('success', 'Message send successfully');

    }

    protected function storeHistory($request)
    {

    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }

    public function smshistory()
    {
        $data['smshistories'] = SmsHistory::latest()->get();
        return view('mail_vendor.sms.history',$data);
    }
}
