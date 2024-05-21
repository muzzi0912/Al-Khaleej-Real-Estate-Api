<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class PropertyController extends Controller
{
     /**
     * Display a listing of the properties.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $properties = Property::with('category')->get();
        return response()->json($properties);
    }

    /**
     * Store a newly created property in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'property_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'sqft' => 'required|string|max:255',
            'number_of_bedrooms' => 'required|integer',
            'number_of_bathrooms' => 'required|integer',
            'property_type' => 'required|string|max:255',
            'property_second_name' => 'nullable|string|max:255',
            'property_description' => 'nullable|string',
            'amenities' => 'nullable|string',
            'listing_price' => 'required|numeric',
            'status' => 'required|in:available,under contract,sold',
            'images.*' => 'nullable|image|max:2048', // Max file size 2MB
            'videos.*' => 'nullable|mimetypes:video/mp4,video/avi,video/mpeg|max:10240', // Max file size 10MB
            'year_built' => 'required|integer',
            'living_rooms' => 'nullable|integer',
            'bedrooms' => 'nullable|integer',
            'all_rooms' => 'nullable|integer',
            'kitchen' => 'nullable|integer',
            'category_id' => 'required|exists:categories,id', // Validate category ID
        ]);
    
        // Check for validation errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Process images and videos
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('property_images', 'public');
            }
        }
    
        $videoPaths = [];
        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $video) {
                $videoPaths[] = $video->store('property_videos', 'public');
            }
        }
    
        // Create a new property
        $property = Property::create([
            'property_name' => $request->input('property_name'),
            'address' => $request->input('address'),
            'sqft' => $request->input('sqft'),
            'number_of_bedrooms' => $request->input('number_of_bedrooms'),
            'number_of_bathrooms' => $request->input('number_of_bathrooms'),
            'property_type' => $request->input('property_type'),
            'property_second_name' => $request->input('property_second_name'),
            'property_description' => $request->input('property_description'),
            'amenities' => $request->input('amenities'),
            'listing_price' => $request->input('listing_price'),
            'status' => $request->input('status'),
            'images' => json_encode($imagePaths),
            'videos' => json_encode($videoPaths),
            'year_built' => $request->input('year_built'),
            'living_rooms' => $request->input('living_rooms'),
            'bedrooms' => $request->input('bedrooms'),
            'all_rooms' => $request->input('all_rooms'),
            'kitchen' => $request->input('kitchen'),
            'category_id' => $request->input('category_id'), // Add category ID
        ]);
    
        // Return the created property
        return response()->json(['message' => 'Property created successfully', 'property' => $property], 201);
    }
    

    /**
     * Display the specified property.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $property = Property::with('category')->find($id);

        if (!$property) {
            return response()->json(['message' => 'Property not found'], 404);
        }

        return response()->json($property);
    }

    /**
     * Update the specified property in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $property = Property::find($id);
    
        if (!$property) {
            return response()->json(['message' => 'Property not found'], 404);
        }
    
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'property_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'sqft' => 'required|string|max:255',
            'number_of_bedrooms' => 'required|integer',
            'number_of_bathrooms' => 'required|integer',
            'property_type' => 'required|string|max:255',
            'property_second_name' => 'nullable|string|max:255',
            'property_description' => 'nullable|string',
            'amenities' => 'nullable|string',
            'listing_price' => 'required|numeric',
            'status' => 'required|in:available,under contract,sold',
            'images.*' => 'nullable|image|max:2048', // Max file size 2MB
            'videos.*' => 'nullable|mimetypes:video/mp4,video/avi,video/mpeg|max:10240', // Max file size 10MB
            'year_built' => 'required|integer',
            'living_rooms' => 'nullable|integer',
            'bedrooms' => 'nullable|integer',
            'all_rooms' => 'nullable|integer',
            'kitchen' => 'nullable|integer',
            'category_id' => 'required|exists:categories,id', // Validate category ID
        ]);
    
        // Check for validation errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Process images and videos
        $imagePaths = json_decode($property->images, true) ?: [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('property_images', 'public');
            }
        }
    
        $videoPaths = json_decode($property->videos, true) ?: [];
        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $video) {
                $videoPaths[] = $video->store('property_videos', 'public');
            }
        }
    
        // Update the property
        $property->update([
            'property_name' => $request->input('property_name'),
            'address' => $request->input('address'),
            'sqft' => $request->input('sqft'),
            'number_of_bedrooms' => $request->input('number_of_bedrooms'),
            'number_of_bathrooms' => $request->input('number_of_bathrooms'),
            'property_type' => $request->input('property_type'),
            'property_second_name' => $request->input('property_second_name'),
            'property_description' => $request->input('property_description'),
            'amenities' => $request->input('amenities'),
            'listing_price' => $request->input('listing_price'),
            'status' => $request->input('status'),
            'images' => json_encode($imagePaths),
            'videos' => json_encode($videoPaths),
            'year_built' => $request->input('year_built'),
            'living_rooms' => $request->input('living_rooms'),
            'bedrooms' => $request->input('bedrooms'),
            'all_rooms' => $request->input('all_rooms'),
            'kitchen' => $request->input('kitchen'),
            'category_id' => $request->input('category_id'), // Update category ID
        ]);
    
        // Return the updated property
        return response()->json(['message' => 'Property updated successfully', 'property' => $property]);
    }
    

    /**
     * Remove the specified property from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $property = Property::find($id);

        if (!$property) {
            return response()->json(['message' => 'Property not found'], 404);
        }

        // Delete the property
        $property->delete();

        return response()->json(['message' => 'Property deleted successfully']);
    }


    /**
     * Display properties belonging to a specific category.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function propertiesByCategory($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $properties = Property::where('category_id', $id)->with('category')->get();

        return response()->json($properties);
    }

    
}
