<?php

namespace App\Http\Controllers\User;

use App\Models\Form;
use App\Constants\Status;
use App\Lib\FormProcessor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FinanceRequest;
use App\Models\MarketingRequest;
use App\Models\Property;
use App\Models\PropertyRequest;
use App\Models\ServiceRequest;
use App\Models\SupportTicket;

class UserController extends Controller
{
    public function home(){

        $supportCount = SupportTicket::where('user_id',auth()->user()->id)->count();
        return view('user.dashboard',compact('supportCount'));
    }

    public function userData()
    {
        $user = auth()->user();
        if ($user->profile_complete == 1) {
            return to_route('user.home');
        }
        return view('user.user_data', compact('user'));
    }

    public function userDataSubmit(Request $request)
    {
        $user = auth()->user();
        if ($user->profile_complete == Status::YES) {
            return to_route('user.home');
        }

        $request->validate([
            'name'=>'required',
        ]);
        $user->name = $request->name;
        $user->position_title = $request->position_title;
        $user->val_license_number = $request->val_license_number;
        $user->address = [
            'country'=>@$user->address->country,
            'address'=>$request->address,
            'state'=>$request->state,
            'zip'=>$request->zip,
            'city'=>$request->city,
        ];
        $user->profile_complete = Status::YES;
        $user->save();

        $notify[] = ['success','Registration process completed successfully'];
        return to_route('user.home')->withNotify($notify);

    }
}
