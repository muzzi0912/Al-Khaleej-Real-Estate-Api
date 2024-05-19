<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'property_name',
        'address',
        'sqft',
        'number_of_bedrooms',
        'number_of_bathrooms',
        'property_type',
        'property_second_name',
        'property_description',
        'amenities',
        'listing_price',
        'status',
        'images',
        'videos',
        'year_built',
        'living_rooms',
        'bedrooms',
        'all_rooms',
        'kitchen',
        'category_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'images' => 'array',
        'videos' => 'array',
    ];

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
