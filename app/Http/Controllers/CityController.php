<?php

namespace App\Http\Controllers;

use App\City;
use Illuminate\Http\Request;
use App\Http\Resources\City as CityResource;

class CityController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->getAll)
            $cities = City::paginate(10);
        else
            $cities = City::all();

        return response($cities, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return CityResource
     */
    public function store(Request $request)
    {
        $city = new City;
        $city->id = $request->input('id');
        $city->name = $request->input('name');
        $city->code = $request->input('code');
        if($city->save()) {
            return new CityResource($city);
        }
        return null;
    }

    /**
     * Update resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return CityResource
     */
    public function update(Request $request)
    {
        $city = City::findOrFail($request->id);
        $city->id = $request->input('id');
        $city->name = $request->input('name');
        $city->code = $request->input('code');
        if($city->save()) {
            return new CityResource($city);
        }
        return null;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return CityResource
     */
    public function show($id)
    {
        // Get country
        $city = City::findOrFail($id);
        // Return single country as a resource
        return new CityResource($city);
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
        $city = City::findOrFail($id);
        if($city->delete()) {
            return $city;
        }
    }
}
