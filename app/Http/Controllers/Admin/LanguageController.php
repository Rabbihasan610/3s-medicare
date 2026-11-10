<?php

namespace App\Http\Controllers\Admin;

use App\Models\Language;
use App\Models\Frontend;
use App\Constants\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Pagination\LengthAwarePaginator;

class LanguageController extends Controller
{
    private const MAX_LANG_FILE_BYTES = 5 * 1024 * 1024;
    private const MAX_LANG_KEY_LENGTH = 255;
    private const MAX_LANG_VALUE_LENGTH = 20000;

    public function langManage($lang = false)
    {
        $languages = Language::orderBy('is_default', 'desc')->get();
        return view('admin.language.lang', compact('languages'));
    }

    public function langStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:40',
            'code' => 'required|string|max:40|unique:languages',
        ]);

        // $data = file_get_contents(resource_path('lang/') . 'en.json');
        $data = file_get_contents(resource_path('lang') . '/en.json');
        $json_file = strtolower($request->code) . '.json';
        $path = resource_path('lang/') . $json_file;

        File::put($path, $data);

        $language = new Language();

        if ($request->is_default) {
            $lang = $language->where('is_default', Status::YES)->first();
            if ($lang) {
                $lang->is_default = Status::NO;
                $lang->save();
            }
        }
        $language->name = $request->name;
        $language->code = strtolower($request->code);
        $language->is_default = $request->is_default ? Status::YES : Status::NO;
        $language->save();

        $notify[] = ['success', 'Language added successfully'];
        return back()->withNotify($notify);
    }

    public function langUpdate(Request $request, $id)
    {

        $request->validate([
            'name' => 'required',
        ]);

        $language = Language::findOrFail($id);

        if (!$request->is_default) {
            $defaultLang = Language::where('is_default', Status::YES)->where('id', '!=', $id)->exists();
            if (!$defaultLang) {
                $notify[] = ['error', 'You\'ve to set another language as default before unset this'];
                return back()->withNotify($notify);
            }
        }

        $language->name = $request->name;
        $language->is_default = $request->is_default ? Status::YES : Status::NO;
        $language->save();

        if ($request->is_default) {
            $lang = Language::where('is_default', Status::YES)->where('id', '!=', $language->id)->first();
            if ($lang) {
                $lang->is_default = Status::NO;
                $lang->save();
            }
        }

        $notify[] = ['success', 'Update successfully'];
        return back()->withNotify($notify);
    }

    public function langDelete($id)
    {
        $lang = Language::find($id);
        fileManager()->removeFile(resource_path('lang/') . $lang->code . '.json');
        $lang->delete();
        $notify[] = ['success', 'Language deleted successfully'];
        return back()->withNotify($notify);
    }

    public function langEdit($id)
    {
        $lang = Language::find($id);
        $title = "Update " . $lang->name . " Keywords";
        $json = file_get_contents(resource_path('lang/') . $lang->code . '.json');
        $list_lang = Language::all();

        if (empty($json)) {
            $notify[] = ['error', 'File not found'];
            return back()->withNotify($notify);
        }

        $json = json_decode($json, true);
        if (!is_array($json)) {
            $notify[] = ['error', 'Language file contains invalid JSON'];
            return back()->withNotify($notify);
        }

        $perPage = getPaginate();
        $currentPage = request()->get('page', 1);
        $offset = ($currentPage - 1) * $perPage;

        $search = request()->search;
        if ($search) {
            $json = array_filter(
                $json,
                function ($key) use ($search) {
                    return stripos($key, $search) !== false;
                },
                ARRAY_FILTER_USE_KEY
            );
        }

        $items = array_slice($json, $offset, $perPage, true);

        $json = new LengthAwarePaginator(
            $items,
            count($json),
            $perPage,
            $currentPage,
            ['path' => url()->current()]
        );

        return view('admin.language.edit_lang', compact('title', 'json', 'lang', 'list_lang'));
    }

    public function langImport(Request $request)
    {
        $tolang = Language::find($request->toLangid);
        if (!$tolang) {
            return response('failed', 404);
        }

        try {
            if ($request->id != 999) {
                $fromLang = Language::find($request->id);
                if (!$fromLang) {
                    return response('failed', 404);
                }
                $keywords = array_keys($this->loadLanguageMap($fromLang->code));
            } else {
                $keywords = explode("\n", $this->getKeys());
            }

            $itemData = $this->loadLanguageMap($tolang->code);
            $newArr = [];

            foreach ($keywords as $keyword) {
                $keyword = trim((string) $keyword);
                if ($keyword === '' || isset($itemData[$keyword])) {
                    continue;
                }

                if (!$this->isValidLanguageEntry($keyword, $keyword)) {
                    continue;
                }

                $newArr[$keyword] = $keyword;
            }

            if (!empty($newArr)) {
                $result = array_merge($itemData, $newArr);
                $this->saveLanguageMap($tolang->code, $result);
            }
        } catch (\RuntimeException $e) {
            return response('failed', 422);
        }

        return 'success';
    }

    public function storeLanguageJson(Request $request, $id)
    {

        $lang = Language::find($id);


        $this->validate($request, [
            'key' => 'required',
            'value' => 'required',
        ]);

        $reqKey = trim($request->key);
        $reqValue = trim($request->value);

        if (!$this->isValidLanguageEntry($reqKey, $reqValue)) {
            $notify[] = ['error', "Invalid key/value size for language entry"];
            return back()->withNotify($notify);
        }

        try {
            $itemData = $this->loadLanguageMap($lang->code);
        } catch (\RuntimeException $e) {
            $notify[] = ['error', $e->getMessage()];
            return back()->withNotify($notify);
        }

        if (array_key_exists($reqKey, $itemData)) {
            $notify[] = ['error', "Key already exist"];
            return back()->withNotify($notify);
        } else {
            $newArr[$reqKey] = $reqValue;
            $result = array_merge($itemData, $newArr);
            try {
                $this->saveLanguageMap($lang->code, $result);
            } catch (\RuntimeException $e) {
                $notify[] = ['error', $e->getMessage()];
                return back()->withNotify($notify);
            }
            $notify[] = ['success', "Language key added successfully"];
            return back()->withNotify($notify);
        }
    }
    public function deleteLanguageJson(Request $request, $id)
    {
        $this->validate($request, [
            'key' => 'required',
            'value' => 'required',
        ]);

        $key = $request->key;
        $lang = Language::find($id);
        try {
            $json_arr = $this->loadLanguageMap($lang->code);
        } catch (\RuntimeException $e) {
            $notify[] = ['error', $e->getMessage()];
            return back()->withNotify($notify);
        }
        unset($json_arr[$key]);

        try {
            $this->saveLanguageMap($lang->code, $json_arr);
        } catch (\RuntimeException $e) {
            $notify[] = ['error', $e->getMessage()];
            return back()->withNotify($notify);
        }
        $notify[] = ['success', "Language key deleted successfully"];
        return back()->withNotify($notify);
    }

    public function updateLanguageJson(Request $request, $id)
    {
        $this->validate($request, [
            'key' => 'required',
            'value' => 'required',
        ]);

        $key = trim($request->key);
        $reqValue = $request->value;
        $lang = Language::find($id);

        if (!$this->isValidLanguageEntry($key, $reqValue)) {
            $notify[] = ['error', "Invalid key/value size for language entry"];
            return back()->withNotify($notify);
        }

        try {
            $json_arr = $this->loadLanguageMap($lang->code);
        } catch (\RuntimeException $e) {
            $notify[] = ['error', $e->getMessage()];
            return back()->withNotify($notify);
        }

        $json_arr[$key] = $reqValue;

        try {
            $this->saveLanguageMap($lang->code, $json_arr);
        } catch (\RuntimeException $e) {
            $notify[] = ['error', $e->getMessage()];
            return back()->withNotify($notify);
        }

        $notify[] = ['success', 'Language key updated successfully'];
        return back()->withNotify($notify);
    }

    public function getKeys()
    {
        $langKeys = [];
        $dirname = resource_path('views');
        foreach ($this->getAllFiles($dirname) as $file) {
            $langKeys = array_merge($langKeys, $this->getLangKeys($file));
        }
        $frontendData = Frontend::where('data_keys', '!=', 'seo.data')->get();
        foreach ($frontendData as $frontend) {
            if (!is_iterable($frontend->data_values)) {
                continue;
            }
            foreach ($frontend->data_values as $key => $frontendValue) {
                if (is_string($frontendValue) && $key != 'has_image' && !$this->isImage($frontendValue) && !$this->isHtml($frontendValue)) {
                    $langKeys[] = $frontendValue;
                }
            }
        }
        $langKeys = array_unique($langKeys);
        $keyText = '';
        foreach ($langKeys as $langKey) {
            $keyText .= "$langKey \n";
        }
        return rtrim($keyText, "\n");
    }

    private function isImage($value): bool
    {
        return is_string($value) && (bool) preg_match('/\.(jpg|jpeg|png|gif|svg|webp)$/i', $value);
    }

    private function isHtml($value): bool
    {
        return is_string($value) && $value !== strip_tags($value);
    }

    private function getAllFiles($dir)
    {
        $root = $dir;

        $iter = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($root, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST,
            \RecursiveIteratorIterator::CATCH_GET_CHILD
        );

        $paths = array($root);
        $files = [];
        foreach ($iter as $path => $dir) {
            if (!$dir->isDir() && substr($dir, -4) == '.php') {
                $files[] = $path;
            }
        }

        return $files;
    }

    private function getLangKeys($path)
    {
        $code = file_get_contents($path);
        $keys = [];
        preg_match_all("/@lang\\(\\s*['\"]([^'\"]+)['\"]\\s*\\)/", $code, $langMatches);
        preg_match_all("/__\\(\\s*['\"]([^'\"]+)['\"]\\s*\\)/", $code, $transMatches);

        if (!empty($langMatches[1])) {
            $keys = array_merge($keys, $langMatches[1]);
        }
        if (!empty($transMatches[1])) {
            $keys = array_merge($keys, $transMatches[1]);
        }

        return $this->fixMultiIssue($keys);
    }

    private function fixMultiIssue($arr)
    {
        $res = array();
        foreach ($arr as $keys) {
            $child = trim((string) $keys);
            if ($child === '') {
                continue;
            }

            if (
                str_contains($child, '@lang')
                || str_contains($child, '__(')
                || str_contains($child, '{')
                || str_contains($child, '}')
                || str_contains($child, '<')
                || str_contains($child, '>')
            ) {
                continue;
            }

            if ($this->stringLength($child) > self::MAX_LANG_KEY_LENGTH) {
                continue;
            }

            $res[] = $child;
        }
        return $res;
    }

    private function loadLanguageMap(string $langCode): array
    {
        $path = resource_path('lang/') . strtolower($langCode) . '.json';
        if (!File::exists($path)) {
            throw new \RuntimeException('Language file not found');
        }

        $size = File::size($path);
        if ($size > self::MAX_LANG_FILE_BYTES) {
            throw new \RuntimeException('Language file is too large to process safely');
        }

        $raw = File::get($path);
        $data = json_decode($raw, true);
        if (!is_array($data)) {
            throw new \RuntimeException('Language file contains invalid JSON');
        }

        return $data;
    }

    private function saveLanguageMap(string $langCode, array $payload): void
    {
        $json = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        if ($json === false) {
            throw new \RuntimeException('Failed to encode language JSON');
        }

        $json .= PHP_EOL;
        if (strlen($json) > self::MAX_LANG_FILE_BYTES) {
            throw new \RuntimeException('Language file exceeded safe size limit');
        }

        file_put_contents(resource_path('lang/') . strtolower($langCode) . '.json', $json);
    }

    private function isValidLanguageEntry(string $key, string $value): bool
    {
        return $key !== ''
            && $this->stringLength($key) <= self::MAX_LANG_KEY_LENGTH
            && $this->stringLength($value) <= self::MAX_LANG_VALUE_LENGTH;
    }

    private function stringLength(string $value): int
    {
        if (function_exists('mb_strlen')) {
            return mb_strlen($value);
        }

        return strlen($value);
    }
}
