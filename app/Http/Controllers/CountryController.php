<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;
use App\Http\Resources\Country as CountryResource;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->getAll)
            $countries = Country::paginate(10);
        else
            $countries = Country::all();

        return response($countries, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return CountryResource
     */
    public function store(Request $request)
    {
        $country = new Country;
        $country->id = $request->input('id');
        $country->name = $request->input('name');
        $country->code = $request->input('code');
        if($country->save()) {
            return new CountryResource($country);
        }
        return null;
    }

    /**
     * Update resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return CountryResource
     */
    public function update(Request $request)
    {
        $country = Country::findOrFail($request->id);
        $country->id = $request->input('id');
        $country->name = $request->input('name');
        $country->code = $request->input('code');
        if($country->save()) {
            return new CountryResource($country);
        }
        return null;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return CountryResource
     */
    public function show($id)
    {
        // Get country
        $country = Country::findOrFail($id);
        // Return single country as a resource
        return new CountryResource($country);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get country
        $country = Country::findOrFail($id);
        if($country->delete()) {
            return $country;
        }
    }
}
