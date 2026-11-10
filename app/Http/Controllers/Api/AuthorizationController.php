<?php

namespace App\Http\Controllers\Api;

use App\Constants\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Exception;

class AuthorizationController extends Controller
{
    use ApiResponse;

    public function authorizeForm()
    {
        $user = auth()->user();

        $type = 'email';
        $notifyTemplate = 'EVER_CODE';


        $user->ver_code = verificationCode(6);
        $user->ver_code_send_at = Carbon::now();
        $user->save();

        notify($user, $notifyTemplate, [
            'code' => $user->ver_code
        ],[$type]);

        return  $this->successResponse($user, __('User verification code sent successful'));

    }

    protected function checkCodeValidity($user,$addMin = 2)
    {
        if (!$user->ver_code_send_at){
            return false;
        }
        if ($user->ver_code_send_at->addMinutes($addMin) < Carbon::now()) {
            return false;
        }
        return true;
    }

    public function emailVerification(Request $request)
    {
        $request->validate([
            'code'=>'required'
        ]);

        try {
            $user = auth()->user();

            if ($user->ver_code == $request->code) {
                $user->ev = Status::VERIFIED;
                $user->profile_complete = Status::VERIFIED;
                $user->ver_code = null;
                $user->ver_code_send_at = null;
                $user->save();


                return  $this->successResponse($user, __('User verified'));
            }else{
                return $this->notFound(__('Verification code didn\'t match!'));
            }
        } catch (Exception $e) {
            return $this->notFound(__('Verification code didn\'t match!'));
        }

    }

    public function mobileVerification(Request $request)
    {
        $request->validate([
            'code' => 'required',
        ]);

        try {
            $user = auth()->user();
            if ($user->ver_code == $request->code) {
                $user->sv = Status::VERIFIED;
                $user->profile_complete = Status::VERIFIED;
                $user->ver_code = null;
                $user->ver_code_send_at = null;
                $user->save();

                return  $this->successResponse($user, __('User verified'));
            }else{
                return $this->notFound(__('Verification code didn\'t match!'));
            }
        } catch (Exception $e) {
            return $this->notFound(__('Verification code didn\'t match!'));
        }
    }

    public function sendVerifyCode()
    {
        return $this->authorizeForm();
    }
}
