<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;

class LocationController extends Controller
{
    public function provinces(Request $request)
    {
        return response()->json(Province::orderBy('name', 'asc')->get());
    }

    public function cities(Request $request, $provinceId)
    {
        $province = Province::find($provinceId);
        if (!$province) return response()->json([]);
        return response()->json(City::where('province_code', $province->code)->orderBy('name', 'asc')->get());
    }

    public function districts(Request $request, $cityId)
    {
        $city = City::find($cityId);
        if (!$city) return response()->json([]);
        return response()->json(District::where('city_code', $city->code)->orderBy('name', 'asc')->get());
    }

    public function villages(Request $request, $districtId)
    {
        $district = District::find($districtId);
        if (!$district) return response()->json([]);
        return response()->json(Village::where('district_code', $district->code)->orderBy('name', 'asc')->get());
    }
}
