<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class GlobalController extends Controller
{
    public function getCities($country_id = null)
    {
        try {
            if($country_id){
                $cities  = City::where('country_id', $country_id)->get();
                return $this->success($cities);
            }else{
                $cities  = City::get();
                return $this->success($cities);
            }
        }catch (\Exception $e){
            return $this->error();
        }
    }
}
