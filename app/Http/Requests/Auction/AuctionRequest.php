<?php

namespace App\Http\Requests\Auction;

use App\Rules\FileTypeValidate;
use Illuminate\Foundation\Http\FormRequest;

class AuctionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('id');

        $validation = 'required';

        if ($id) {
            $validation = 'nullable';
        }

        return [
            'title'              => 'required|string|max:191',
            'title_ar'           => 'required|string|max:191',
            'slug'               => 'required|unique:auctions,slug,' . $id,
            'auction_day'        => 'required',
            'auction_date'       => 'required',
            'beginning_time'     => 'required',
            'property_ids'       => 'required|array',
            'property_ids.*'     => 'exists:properties,id',
            'country_id'         => 'required|exists:countries,id',
            'city_id'            => 'required|exists:cities,id',
            'latitude'           => 'required',
            'longitude'          => 'required',
            'description'        => 'required',
            'status'             => 'required',
            'description_ar'     => 'required',
            'document'           => 'nullable|mimes:pdf',
            'thumb_image'        => [$validation, 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'images'             => 'nullable|array',
            'images.*'           => ['image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ];

    }
}
