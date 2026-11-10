<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use App\Constants\Status;
use App\Models\UserLogin;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\AdminNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    use ApiResponse;

    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            "username"  => "required|exists:users,username",
            "password"  => "required"
        ]);


        if($validator->fails()){
            return $this->validationError($validator->errors());
        }

        try {
            $user = User::where('username', $request->username)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                return $this->notFound(__('The provided credentials are incorrect.'));
            }

            $token = $user->createToken($request->device_name)->accessToken;

            $data = [
                "token" => $token,
                "type"  => "Bearer token"
            ];

            return $this->successResponse($data, __('Login successful'));
        } catch (Exception $e) {
            return $this->serverError();
        }
    }

    public function register(Request $request)
    {
        try {

            $validator = $this->validator($request->all());

            if($validator->fails()){
                return $this->validationError($validator->errors());
            }


            if (!preg_match("/^[a-z0-9_]+$/", trim($request->username))) {
                $notify = __('Username can contain only small letters, numbers, and underscores.');
                return $this->validationError($notify);
            }

            if (!verifyCaptcha()) {
                $notify = __('Invalid captcha provided');
                return $this->validationError($notify);
            }

            $exist = User::where('mobile', $request->mobile)->first();

            if ($exist) {
                $notify = __('The mobile number already exists');
                return $this->validationError($notify);
            }

            $user = $this->create($request->all());

            $type = 'email';
            $notifyTemplate = 'EVER_CODE';


            $user->ver_code = verificationCode(6);
            $user->ver_code_send_at = Carbon::now();
            $user->save();

            notify($user, $notifyTemplate, [
                'code' => $user->ver_code
            ],[$type]);

            event(new Registered($user));
            
            $token = $user->createToken($request->device_name)->accessToken;

            $user['token'] = $token;

            return $this->successResponse($user, __('User register success'));
        } catch (Exception $e) {

            return $e->getMessage();
            return $this->serverError();
        }
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

    protected function validator(array $data)
    {
        $general = gs();
        $passwordValidation = Password::min(6);

        if ($general->secure_password) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $agree = 'nullable';

        if ($general->agree) {
            $agree = 'required';
        }

        $validator = Validator::make($data, [
            'email' => 'required|string|email|unique:users',
            'mobile' => 'required|unique:users|regex:/^([0-9]*)$/',
            'password' => ['required','confirmed',$passwordValidation],
            'username' => 'required|unique:users|min:6',
            'captcha' => 'sometimes|required',
            'country' => 'required|exists:countries,id',
            'agree' => $agree
        ]);

        return $validator;
    }


    protected function create(array $data)
    {
        //User Create
        $user = new User();
        $user->email = strtolower($data['email']);
        $user->password = Hash::make($data['password']);
        $user->username = $data['username'];
        $user->country_id = $data['country'];
        $user->mobile = $data['mobile'];
        $user->address = [
            'address' => '',
            'state' => '',
            'zip' => '',
            'city' => ''
        ];
        $user->ev = gs()->ev ? Status::NO : Status::YES;
        $user->sv = gs()->sv ? Status::NO : Status::YES;
        $user->save();


        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'New member registered';
        $adminNotification->click_url =  urlPath('admin.users.detail',$user->id);
        $adminNotification->save();


        //Login Log Create
        $ip = getRealIP();
        $exist = UserLogin::where('user_ip',$ip)->first();
        $userLogin = new UserLogin();

        //Check exist or not
        if ($exist) {
            $userLogin->longitude =  $exist->longitude;
            $userLogin->latitude =  $exist->latitude;
            $userLogin->city =  $exist->city;
            $userLogin->country_code = $exist->country_code;
            $userLogin->country =  $exist->country;
        }else{
            $info = json_decode(json_encode(getIpInfo()), true);
            $userLogin->longitude =  @implode(',',$info['long']);
            $userLogin->latitude =  @implode(',',$info['lat']);
            $userLogin->city =  @implode(',',$info['city']);
            $userLogin->country_code = @implode(',',$info['code']);
            $userLogin->country =  @implode(',', $info['country']);
        }

        $userAgent = osBrowser();
        $userLogin->user_id = $user->id;
        $userLogin->user_ip =  $ip;

        $userLogin->browser = @$userAgent['browser'];
        $userLogin->os = @$userAgent['os_platform'];
        $userLogin->save();


        return $user;
    }


    public function checkUser(Request $request){
        $exist['data'] = false;
        $exist['type'] = null;
        if ($request->email) {
            $exist['data'] = User::where('email',$request->email)->exists();
            $exist['type'] = 'email';
        }
        if ($request->mobile) {
            $exist['data'] = User::where('mobile',$request->mobile)->exists();
            $exist['type'] = 'mobile';
        }
        if ($request->username) {
            $exist['data'] = User::where('username',$request->username)->exists();
            $exist['type'] = 'username';
        }

        return $this->notFound($exist);
    }

    public function userData(Request $request){

        $user = auth()->user();



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

        $message = __('Registration process completed successfully');
        return $this->success($message);
    }

}
