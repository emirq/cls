<?php

namespace App\Http\Controllers;

use App\Http\Resources\IndustryType as IndustryTypeResource;
use App\IndustryType;
use Illuminate\Http\Request;

class IndustryTypeController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->getAll)
            $industryType = IndustryType::paginate(10);
        else
            $industryType = IndustryType::all();

        return response($industryType, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return IndustryTypeResource
     */
    public function store(Request $request)
    {
        $industryType = new IndustryType;
        $industryType->id = $request->input('id');
        $industryType->name = $request->input('name');
        if($industryType->save()) {
            return new IndustryTypeResource($industryType);
        }
        return null;
    }

    /**
     * Update resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return IndustryTypeResource
     */
    public function update(Request $request)
    {
        $industryType = IndustryType::findOrFail($request->id);
        $industryType->id = $request->input('id');
        $industryType->name = $request->input('name');
        if($industryType->save()) {
            return new IndustryTypeResource($industryType);
        }
        return null;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return IndustryTypeResource
     */
    public function show($id)
    {
        // Get country
        $industryType = IndustryType::findOrFail($id);
        // Return single country as a resource
        return new IndustryTypeResource($industryType);
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
        $industryType = IndustryType::findOrFail($id);
        if($industryType->delete()) {
            return $industryType;
        }
    }
}
