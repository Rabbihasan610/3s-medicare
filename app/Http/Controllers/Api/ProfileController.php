<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    use ApiResponse;

    public function profile()
    {
        $user = auth()->user();

        return $this->successResponse($user, __('Profile'));
    }

    public function submitProfile(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'image' => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);


        if($validator->fails()){
            return $this->validationError($validator->errors());
        }

        $user = auth()->user();

        if ($request->hasFile('image')) {
            try {
                $old = $user->image;
                $user->image = fileUploader($request->image, getFilePath('userProfile'), getFileSize('userProfile'), $old);
                //$user->avatar = fileUploader($request->avatar, getFilePath('userProfile'), getFileSize('userProfile'), $user->avatar);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->position_title = $request->position_title;
        $user->val_license_number = $request->val_license_number;
        $user->address = [
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => @$user->address->country,
            'city' => $request->city,
        ];

        $user->save();


        $notify = __('Profile updated successfully');

        return $this->successResponse($user, $notify);
    }


    public function submitPassword(Request $request)
    {

        $passwordValidation = Password::min(6);

        if (gs('secure_password')) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => ['required', 'confirmed', $passwordValidation],
        ]);

        if($validator->fails()){
            return $this->validationError($validator->errors());
        }


        $user = auth()->user();
        if (Hash::check($request->current_password, $user->password)) {
            $password = Hash::make($request->password);
            $user->password = $password;
            $user->save();

            $notify = __('Password changes successfully');

            return $this->successResponse($user, $notify);
        } else {
            $notify = __('The password doesn\'t match!');

            return $this->notFound($notify);
        }
    }
}
