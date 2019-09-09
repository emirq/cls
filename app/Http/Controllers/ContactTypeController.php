<?php

namespace App\Http\Controllers;

use App\ContactType;
use App\Http\Resources\ContactType as ContactTypeResource;
use Illuminate\Http\Request;

class ContactTypeController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->getAll)
            $contactTypes = ContactType::paginate(10);
        else
            $contactTypes = ContactType::all();

        return response($contactTypes, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return ContactTypeResource
     */
    public function store(Request $request)
    {
        $contactType = new ContactType;
        $contactType->id = $request->input('id');
        $contactType->name = $request->input('name');
        if($contactType->save()) {
            return new ContactTypeResource($contactType);
        }
        return null;
    }

    /**
     * Update resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return ContactTypeResource
     */
    public function update(Request $request)
    {
        $contactType = ContactType::findOrFail($request->id);
        $contactType->id = $request->input('id');
        $contactType->name = $request->input('name');
        if($contactType->save()) {
            return new ContactTypeResource($contactType);
        }
        return null;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return ContactTypeResource
     */
    public function show($id)
    {
        // Get country
        $contactType = ContactType::findOrFail($id);
        // Return single country as a resource
        return new ContactTypeResource($contactType);
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
        $contactType = ContactType::findOrFail($id);
        if($contactType->delete()) {
            return $contactType;
        }
    }
}
