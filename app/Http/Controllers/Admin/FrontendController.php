<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Extension;
use App\Models\Frontend;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class FrontendController extends Controller
{


    public function seoEdit()
    {
        $seo = Frontend::where('data_keys', 'seo.data')->first();
        if (!$seo) {
            $data_values = [
                'keywords' => [
                    'Healthcare Digital Growth',
                    'Medical Website Design',
                    'Doctor SEO',
                    'Clinic Marketing',
                    'Hospital Software',
                    'Patient Appointment System',
                ],
                'description' => '3S Medi Care provides end-to-end digital growth solutions for doctors, clinics, hospitals, and diagnostic centers.',
                'social_title' => '3S Medi Care - Healthcare Expertise. Our Digital Growth.',
                'social_description' => 'Healthcare digital growth agency specializing in medical websites, local SEO ranking, patient appointment systems, and healthcare marketing.',
                'google_verification' => '',
                'bing_verification' => '',
                'robots_meta' => 'index, follow',
                'canonical_url' => '',
                'image' => null,
            ];
            $seo = new Frontend();
            $seo->data_keys = 'seo.data';
            $seo->data_values = $data_values;
            $seo->save();
        }

        $googleExt = Extension::where('act', 'google-site-verification')->first();
        $bingExt = Extension::where('act', 'bing-site-verification')->first();

        return view('admin.frontend.seo', compact('seo', 'googleExt', 'bingExt'));
    }

    public function frontendContent(Request $request, $key)
    {
        $purifier = new \HTMLPurifier();
        $valInputs = $request->except('_token', 'image_input', 'key', 'status', 'type', 'id');
        foreach ($valInputs as $keyName => $input) {
            if (gettype($input) == 'array') {
                $inputContentValue[$keyName] = $input;
                continue;
            }
            $inputContentValue[$keyName] = htmlspecialchars_decode($purifier->purify($input));
        }

        $type = $request->type;
        if (!$type) {
            abort(404);
        }
        $imgJson = @getPageSections()->$key->$type->images;
        $validationRule = [];
        $validationMessage = [];
        foreach ($request->except('_token', 'video') as $inputField => $val) {
            if ($inputField == 'has_image' && $imgJson) {
                foreach ($imgJson as $imgValKey => $imgJsonVal) {
                    $validationRule['image_input.' . $imgValKey] = ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])];
                    $validationMessage['image_input.' . $imgValKey . '.image'] = keyToTitle($imgValKey) . ' must be an image';
                    $validationMessage['image_input.' . $imgValKey . '.mimes'] = keyToTitle($imgValKey) . ' file type not supported';
                }
                continue;
            } elseif ($inputField == 'seo_image') {
                $validationRule['image_input'] = ['nullable', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])];
                continue;
            }
           
            
        // $validationRule[$inputField] = $key == 'promotion' ? 'nullable' : 'required';
           
        }
        $request->validate($validationRule, $validationMessage, ['image_input' => 'image']);
        if ($request->id) {
            $content = Frontend::findOrFail($request->id);
        } else {
            $content = Frontend::where('data_keys', $key . '.' . $request->type)->first();
            if (!$content || $request->type == 'element') {
                $content = new Frontend();
                $content->data_keys = $key . '.' . $request->type;
                $content->save();
            }
        }
        if ($type == 'data') {
            $inputContentValue['image'] = @$content->data_values->image;
            if ($request->hasFile('image_input')) {
                try {
                    $inputContentValue['image'] = fileUploader($request->image_input, getFilePath('seo'), getFileSize('seo'), @$content->data_values->image);
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Couldn\'t upload the image'];
                    return back()->withNotify($notify);
                }
            }
        } else {
       
            if ($imgJson) {
                foreach ($imgJson as $imgKey => $imgValue) {
                    $imgData = @$request->image_input[$imgKey];
                    if (is_file($imgData)) {
                        try {
                            $inputContentValue[$imgKey] = $this->storeImage($imgJson, $type, $key, $imgData, $imgKey, @$content->data_values->$imgKey);
                        } catch (\Exception $exp) {
                            $notify[] = ['error', 'Couldn\'t upload the image'];
                            return back()->withNotify($notify);
                        }
                    } else if (isset($content->data_values->$imgKey)) {
                        $inputContentValue[$imgKey] = $content->data_values->$imgKey;
                    }
                }
            }
        }
        if ($key == 'seo') {
            if ($request->has('google_verification')) {
                $code = trim($request->google_verification);
                if (preg_match('/content=[\'"]([^\'"]+)[\'"]/', $code, $m)) {
                    $code = $m[1];
                }
                $inputContentValue['google_verification'] = $code;

                $ext = Extension::where('act', 'google-site-verification')->first();
                if ($ext) {
                    $shortcode = $ext->shortcode;
                    if (isset($shortcode->verification_code)) {
                        $shortcode->verification_code->value = $code ?: '------';
                    }
                    $ext->shortcode = $shortcode;
                    $ext->status = !empty($code) ? Status::ENABLE : Status::DISABLE;
                    $ext->save();
                }
            }

            if ($request->has('bing_verification')) {
                $code = trim($request->bing_verification);
                if (preg_match('/content=[\'"]([^\'"]+)[\'"]/', $code, $m)) {
                    $code = $m[1];
                }
                $inputContentValue['bing_verification'] = $code;

                $ext = Extension::where('act', 'bing-site-verification')->first();
                if ($ext) {
                    $shortcode = $ext->shortcode;
                    if (isset($shortcode->verification_code)) {
                        $shortcode->verification_code->value = $code ?: '------';
                    }
                    $ext->shortcode = $shortcode;
                    $ext->status = !empty($code) ? Status::ENABLE : Status::DISABLE;
                    $ext->save();
                }
            }

            if ($request->has('robots_meta')) {
                $inputContentValue['robots_meta'] = $request->robots_meta;
            }
            if ($request->has('canonical_url')) {
                $inputContentValue['canonical_url'] = $request->canonical_url;
            }

            Cache::forget('seo.data');
            Artisan::call('view:clear');
        }

        $content->data_values = $inputContentValue;
        
        $content->save();
        $notify[] = ['success', 'Content updated successfully'];
        return back()->withNotify($notify);
    }

    public function frontendSections($key)
    {
        
        $section = @getPageSections()->$key;
        abort_if(!$section || !$section->builder,404);
        $content = Frontend::where('data_keys', $key . '.content')->orderBy('id','desc')->first();
        $elements = Frontend::where('data_keys', $key . '.element')->orderBy('id')->orderBy('id','desc')->get();
        return view('admin.frontend.index', compact('section', 'content', 'elements', 'key'));
    }


    protected function storeImage($imgJson,$type,$key,$image,$imgKey,$old_image = null)
    {
        $path = 'assets/images/frontend/' . $key;
        if ($type == 'element' || $type == 'content') {
            $size = @$imgJson->$imgKey->size;
            $thumb = @$imgJson->$imgKey->thumb;
        }else{
            $path = getFilePath($key);
            $size = getFileSize($key);
            $thumb = @fileManager()->$key()->thumb;
        }
        return fileUploader($image, $path, $size, $old_image, $thumb);
    }

    public function frontendElement($key, $id = null)
    {
        $section = @getPageSections()->$key;
        if (!$section) {
            return abort(404);
        }

        unset($section->element->modal);
        $title = $section->name . ' Items';
        if ($id) {
            $data = Frontend::findOrFail($id);
            return view('admin.frontend.element', compact('section', 'key', 'title', 'data'));
        }
        return view('admin.frontend.element', compact('section', 'key', 'title'));
    }

    public function remove($id)
    {
        $frontend = Frontend::findOrFail($id);
        $key = explode('.', @$frontend->data_keys)[0];
        $type = explode('.', @$frontend->data_keys)[1];
        if (@$type == 'element' || @$type == 'content') {
            $path = 'assets/images/frontend/' . $key;
            $imgJson = @getPageSections()->$key->$type->images;
            if ($imgJson) {
                foreach ($imgJson as $imgKey => $imgValue) {
                    fileManager()->removeFile($path . '/' . @$frontend->data_values->$imgKey);
                    fileManager()->removeFile($path . '/thumb_' . @$frontend->data_values->$imgKey);
                }
            }
        }
        $frontend->delete();
        $notify[] = ['success', 'Content removed successfully'];
        return back()->withNotify($notify);
    }


}
