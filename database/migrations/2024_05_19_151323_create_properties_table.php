<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('property_name');
            $table->string('address');
            $table->string('sqft');
            $table->integer('number_of_bedrooms');
            $table->integer('number_of_bathrooms');
            $table->string('property_type');
            $table->string('property_second_name')->nullable();
            $table->longText('property_description')->nullable();
            $table->string('amenities')->nullable();
            $table->decimal('listing_price', 10, 2);
            $table->enum('status', ['available', 'under contract', 'sold'])->default('available');
            $table->json('images')->default('[]');
            $table->json('videos')->default('[]');
            $table->year('year_built');
            $table->integer('living_rooms')->nullable();
            $table->integer('bedrooms')->nullable();
            $table->integer('all_rooms')->nullable();
            $table->integer('kitchen')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};

