<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreContactRequest;
use App\Http\Requests\V1\UpdateContactRequest;
use App\Http\Resources\V1\ContactCollection;
use App\Http\Resources\V1\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     $type = $request->input("type");

    //     if (!isset($type)) {
    //         return new ContactCollection(Contact::all());
    //     } else {
    //         return new ContactCollection(Contact::where('type', $type)
    //             ->with(['debts' => function ($query) {
    //                 $query->where('is_paid', false);
    //             }])
    //             ->get());
    //     }
    // }

    // public function index(Request $request)
    // {
    //     $type = $request->input("type");

    //     if (!isset($type)) {
    //         return new ContactCollection(Contact::all());
    //     } else {
    //         return new ContactCollection(Contact::where('type', $type)
    //             ->with(['debts' => function ($query) {
    //                 $query->with(['payments']); // Include all payments
    //             }])
    //             ->whereHas('debts.payments', function ($query) {
    //                 $query->where('is_paid', false); // Filter debts with unpaid payments
    //             })
    //             ->get());
    //     }
    // }

    // public function index(Request $request)
    // {
    //     $type = $request->input("type");

    //     if (!isset($type)) {
    //         return new ContactCollection(Contact::all());
    //     } else {
    //         return new ContactCollection(Contact::where('type', $type)
    //             ->with([
    //                 'debts' => function ($query) {
    //                     $query->with(['payments'])
    //                         ->whereHas(
    //                             'payments',
    //                             function ($query) {
    //                                 $query->where('is_paid', false);
    //                             }
    //                         );
    //                 }

    //             ])
    //             ->with(['debts.payments']) // Ensure all payments are included
    //             ->get());
    //     }
    // }

    public function index(Request $request)
    {
        $type = $request->input("type");
        return new ContactCollection(Contact::where('type', $type)
            // ->with(['debts.payments'])
            ->get());
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
