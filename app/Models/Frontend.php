<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Frontend extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'data_values' => 'object',
    ];

    public static function scopeGetContent($data_keys)
    {
        return Frontend::where('data_keys', $data_keys);
    }

    public function lang($colum = null)
    {
        if (!$colum) {
            return 'Colum name empty';
        }

        $langCode = Session::get('lang', 'en');
        $columName = $colum . '_' . $langCode;

        // Check for language-specific column first (e.g. description_ar, description_en)
        if (!empty($this->data_values->$columName)) {
            return $this->data_values->$columName;
        }

        // Fall back to base column
        return $this->data_values->$colum;
    }
}
