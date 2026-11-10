<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Mockery\Exception;
use Illuminate\Support\Facades\DB;



class CountryController extends Controller
{

    public function index(Request $request)
    {
        $countries = Country::withCount(['city'])
        ->orderByRaw('ISNULL(sort_order), sort_order')
        ->searchable(['name', 'name_ar'])
        ->paginate(getPaginate());

        // $countries = sortOrder($o_countries);

        $countriesAll = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        return view('admin.country.index', compact('countries','countriesAll'));

    }

    public function store(Request $request, $id = null)
    {
        $request->validate([
            'name' => 'required|string',
            'name_ar' => 'required|string',
            'sort_order' => 'nullable|integer',
        ]);

        $country = $id ? Country::findOrFail($id) : new Country();

        $country->name = $request->name;
        $country->name_ar = $request->name_ar;

        if ($request->has('sort_order')) {
            $newSortOrder = $request->sort_order;

            if ($id) {
                $oldSortOrder = $country->sort_order;
                $country->sort_order = $newSortOrder;
            } else {
                $country->sort_order = $newSortOrder;
            }

            $country->save();

            if ($id && $oldSortOrder !== $newSortOrder) {

                $countriesToUpdate = Country::where('sort_order', '>=', $oldSortOrder)
                                            ->where('id', '!=', $country->id)
                                            ->orderBy('sort_order', 'desc')
                                            ->get();
                foreach ($countriesToUpdate as $sc) {
                    $sc->sort_order += 1;
                    $sc->save();
                }
            } elseif (!$id) {

                Country::where('sort_order', '>=', 6)
                        ->increment('sort_order');
            }
        } else {
            $country->save();
        }

        $message = $id ? 'Country updated successfully' : 'Country created successfully';
        $notify = [['success', $message]];

        return redirect()->back()->withNotify($notify);
    }


}
