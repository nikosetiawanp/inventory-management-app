<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\UpdateVendorRequest;
use App\Http\Resources\V1\VendorCollection;
use App\Models\Vendor;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\VendorResource;
use App\Http\Requests\V1\StoreVendorRequest;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new VendorCollection(Vendor::paginate());
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
    public function store(StoreVendorRequest $request)
    {
        return new VendorResource(Vendor::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Vendor $vendor)
    {
        return new VendorResource($vendor);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vendor $vendor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVendorRequest $request, Vendor $vendor)
    {
        $vendor->update($request->all());
        return new VendorResource($vendor);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vendor $vendor)
    {
        if ($vendor) {
            $vendor->delete();
        }
    }
}
