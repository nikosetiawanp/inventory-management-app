<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\StoreProductRequest;
use App\Http\Requests\V1\UpdateProductRequest;
use App\Http\Resources\V1\ProductCollection;
use App\Http\Resources\V1\ProductResource;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProductHistory(Request $request)
    {
        $startDate = $request->input('startDate'); // Expecting 'YYYY-MM-DD'
        $endDate = $request->input('endDate'); // Expecting 'YYYY-MM-DD'

        if (!$startDate || !$endDate) {
            return [];
        }

        $products = Product::with(['inventoryItems.inventory'])->get()->map(function ($product) use ($startDate, $endDate) {
            // Calculate initialQuantity: sum of all inventoryItems quantities before startDate
            $initialQuantity = $product->inventoryItems->filter(function ($item) use ($startDate) {
                return $item->inventory->date < $startDate;
            })->reduce(function ($carry, $item) {
                return $item->inventory->type === 'A'
                    ? $carry + $item->quantity
                    : $carry - $item->quantity;
            }, 0);

            // Filter inventoryItems by the provided startDate and endDate
            $filteredItems = $product->inventoryItems->filter(function ($item) use ($startDate, $endDate) {
                return $item->inventory->date >= $startDate && $item->inventory->date <= $endDate;
            });

            // Calculate currentQuantity based on filtered inventory type, or set to initialQuantity if no items are found
            $currentQuantity = $filteredItems->isEmpty() ? $initialQuantity : $filteredItems->reduce(function ($carry, $item) {
                return $item->inventory->type === 'A'
                    ? $carry + $item->quantity
                    : $carry - $item->quantity;
            }, 0);

            // Set initialQuantity and currentQuantity on the product
            $product->initialQuantity = $initialQuantity;
            $product->currentQuantity = $currentQuantity;

            // Replace inventoryItems with filtered ones
            $product->inventoryItems = $filteredItems;

            return $product;
        });

        return response()->json([
            'data' => $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'code' => $product->code,
                    'name' => $product->name,
                    'unit' => $product->unit,
                    'initialQuantity' => $product->initialQuantity, // Include initialQuantity
                    'currentQuantity' => $product->currentQuantity, // Include currentQuantity
                    'history' => $product->inventoryItems->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'quantity' => $item->quantity,
                            'number' => $item->inventory->number,
                            'type' => $item->inventory->type,
                            'receiptNumber' => $item->inventory->receipt_number,
                            'date' => $item->inventory->date,
                            'description' => $item->inventory->description
                        ];
                    }),
                ];
            }),
        ]);
    }





    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['inventoryItems.inventory'])->get()->map(function ($product) {
            // Calculate currentQuantity based on inventory type
            $product->currentQuantity = $product->inventoryItems->reduce(function ($carry, $item) {
                return $item->inventory->type === 'A'
                    ? $carry + $item->quantity
                    : $carry - $item->quantity;
            }, 0);

            return $product;
        });

        return response()->json([
            'data' => $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'code' => $product->code,
                    'name' => $product->name,
                    'unit' => $product->unit,
                    'currentQuantity' => $product->currentQuantity, // Include currentQuantity here
                    // 'inventoryItems' => $product->inventoryItems->map(function ($item) {
                    //     return [
                    //         'id' => $item->id,
                    //         'quantity' => $item->quantity,
                    //         'productId' => $item->product_id,
                    //         'inventoryId' => $item->inventory_id,
                    //         'inventory' => [
                    //             'id' => $item->inventory->id,
                    //             'number' => $item->inventory->number,
                    //             'date' => $item->inventory->date,
                    //             'type' => $item->inventory->type,
                    //             'receiptNumber' => $item->inventory->receipt_number,
                    //             'description' => $item->inventory->description,
                    //             'transactionId' => $item->inventory->transaction_id,
                    //         ],
                    //     ];
                    // }),
                ];
            }),
        ]);
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
    public function store(StoreProductRequest $request)
    {
        return new ProductResource(Product::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->all());
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product) {
            $product->delete();
        }
    }
}
