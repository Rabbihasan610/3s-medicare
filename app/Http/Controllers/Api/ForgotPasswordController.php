<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;


class ForgotPasswordController extends Controller
{
    use ApiResponse;

    public function sendResetCodeEmail(Request $request)
    {
        $request->validate([
            'value'=>'required'
        ]);

        if(!verifyCaptcha()){
            $notify = __('Invalid captcha provided');
            return $this->notFound($notify);
        }

        $fieldType = $this->findFieldType();
        $user = User::where($fieldType, $request->value)->first();

        if (!$user) {
            $notify = __('Couldn\'t find any account with this information');
            return $this->notFound($notify);
        }

        PasswordReset::where('email', $user->email)->delete();
        $code = verificationCode(6);
        $password = new PasswordReset();
        $password->email = $user->email;
        $password->token = $code;
        $password->created_at = Carbon::now();
        $password->save();

        $userIpInfo = getIpInfo();
        $userBrowserInfo = osBrowser();

        notify($user, 'PASS_RESET_CODE', [
            'code' => $code,
            'operating_system' => @$userBrowserInfo['os_platform'],
            'browser' => @$userBrowserInfo['browser'],
            'ip' => @$userIpInfo['ip'],
            'time' => @$userIpInfo['time']
        ],['email']);

        $email = $user->email;


        $notify = __('Password reset email sent successfully');

        return $this->successResponse($email, $notify);
    }



    /**
     * Verify the reset code.
     *
     * @param \Illuminate\Http\Request $request The request object.
     * @return \Illuminate\Http\JsonResponse The JSON response.
     */
    public function verifyCode(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'code' => 'required',
            'email' => 'required'
        ]);

        $code = $request->code;

        if (PasswordReset::where('token', $code)
            ->where('email', $request->email)
            ->count() != 1) {
            $notify = __('Verification code doesn\'t match');

            return $this->notFound($notify);
        }

        // Generate session for password reset email and code
        $session_id = rand(100000, 999999)
            . '-' . $request->email
            . '-' . $code
            . '-' . time();

       Cache::put($session_id, $session_id, 60 * 60);


        return $this->successResponse([
            'session_id' => $session_id
        ], 'Code verified successfully');


        //return $this->successResponse($session, $notify);
    }


    public function findFieldType()
    {
        $input = request()->input('value');

        $fieldType = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$fieldType => $input]);

        return $fieldType;
    }


    public function resetPassword(Request $request)
    {
        try {
            // Password validation setup
            $passwordValidation = Password::min(6);

            if (gs('secure_password')) {
                $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
            }

            // Validate the request inputs
            $validator = Validator::make($request->all(), [
                'session_id' => 'required',
                'password' => ['required', $passwordValidation, 'confirmed'],
            ]);

            // Handle validation errors
            if ($validator->fails()) {
                return $this->validationError($validator->errors());
            }

            $session_id = $request->session_id;


            $session = Cache::get($session_id);

            // get cached
            // Validate session
            if (!$session) {
                $notify = __('Verification session doesn\'t match');
                return $this->notFound($notify);
            }

            // Extract details from the session
            $extract = explode('-', $session);


            if (count($extract) < 4) {
                $notify = __('Invalid session format');
                return $this->notFound($notify);
            }

            $email = $extract[1];
            $code = $extract[2];
            $time = $extract[3];

            // Validate the reset token
            if (PasswordReset::where('token', $code)->where('email', $email)->count() != 1) {
                $notify = __('Verification session doesn\'t match');
                return $this->notFound($notify);
            }

            // Find the user and update their password
            $user = User::where('email', $email)->first();
            $user->update([
                'password' => Hash::make($request->password)
            ]);


            // Delete the cached session
            Cache::forget($session_id);

            return $this->successResponse($user, __('Password reset successfully'));
        } catch (\Exception $e) {

            return $e->getMessage();

            return $this->serverError();
        }
    }


}
