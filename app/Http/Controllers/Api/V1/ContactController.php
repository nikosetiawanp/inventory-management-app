<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreContactRequest;
use App\Http\Requests\V1\UpdateContactRequest;
use App\Http\Resources\V1\ContactCollection;
use App\Http\Resources\V1\ContactResource;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ContactCollection(Contact::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request)
    {
        return new ContactResource(Contact::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        return new ContactResource($contact);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        $contact->update($request->all());
        return new ContactResource($contact);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        if ($contact) {
            $contact->delete();
        }
    }
}
