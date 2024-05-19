<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Property;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class OfferController extends Controller
{
    /**
     * Display a listing of offers.
     */
    public function index()
    {
        $offers = Offer::with(['user', 'property'])->get();
        return response()->json($offers);
    }

    /**
     * Store a newly created offer in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'property_id' => 'required|exists:properties,id',
            'offer_amount' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $offer = Offer::create($request->all());
        return response()->json(['message' => 'Offer created successfully', 'data' => $offer], 201);
    }

    /**
     * Display the specified offer.
     */
    public function show($id)
    {
        $offer = Offer::with(['user', 'property'])->findOrFail($id);
        return response()->json($offer);
    }

    /**
     * Update the specified offer in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'property_id' => 'required|exists:properties,id',
            'offer_amount' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $offer = Offer::findOrFail($id);
        $offer->update($request->all());
        return response()->json(['message' => 'Offer updated successfully', 'data' => $offer]);
    }

     /**
     * Remove the specified offer from storage.
     */
    public function destroy($id)
    {
        $offer = Offer::findOrFail($id);
        $offer->delete();
        return response()->json(['message' => 'Offer deleted successfully']);
    }
}
