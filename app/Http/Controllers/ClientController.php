<?php

namespace App\Http\Controllers;

use App\Client;
use App\Country;
use App\Contact;
use Illuminate\Http\Request;
use App\Http\Resources\Client as ClientResource;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::with('contacts', 'country', 'city', 'industryType')->paginate(10);

        return response($clients, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return ClientResource
     */
    public function store(Request $request)
    {
        $client = new Client;
        $client->name = $request->input('name');
        $client->address = $request->input('address');
        $client->city_id = $request->input('city_id');
        $client->country_id = $request->input('country_id');
        $client->industry_type_id = $request->input('industry_type_id');
        $contacts = $request->input('contacts');

        $client->save();
        foreach ($contacts as $contact) {
            $newContact = new Contact;
            $newContact->content = $contact['content'];
            $newContact->contact_type_id = $contact['contact_type_id'];
            $newContact->client_id = $client->id;
            $newContact->save();
        }
        if ($client->save()) {
            return new ClientResource($client);
        }
        return null;
    }

    /**
     * Update resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return ClientResource
     */
    public function update(Request $request)
    {
        $client = Client::findOrFail($request->id);
        $client->name = $request->input('name');
        $client->address = $request->input('address');
        $client->city_id = $request->input('city_id');
        $client->country_id = $request->input('country_id');
        $client->industry_type_id = $request->input('industry_type_id');
        $contacts = $request->input('contacts');
        $client->save();
        $oldContact = Contact::where('client_id', $client->id);
        $oldContact->delete();
        foreach ($contacts as $contact) {
            $newContact = new Contact;
            $newContact->content = $contact['content'];
            $newContact->contact_type_id = $contact['contact_type_id'];
            $newContact->client_id = $client->id;
            $newContact->save();
        }
        if ($client->save()) {
            return new ClientResource($client);
        }
        return null;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return ClientResource
     */
    public function show($id)
    {
        // Get client
        $client = Client::with('country', 'contacts', 'city', 'industryType')->findOrFail($id);
        // Return single client as a resource
        return $client;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get client
        $client = Client::findOrFail($id);
        if($client->delete()) {
            return $client;
        }
        return null;
    }
}
