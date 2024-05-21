<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/

// Admin Authenticate
Route::post('/admin/login', [AdminController::class, 'login']);

// Log the Admin Out
Route::post('/admin/logout', [AdminController::class, 'logout'])->middleware('auth:sanctum');

// Get details of the logged-in Admin
Route::get('/admin/logged-admin', [AdminController::class, 'loggedAdmin'])->middleware('auth:sanctum');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

// Register a new client
Route::post('/register', [AuthController::class, 'register']);

// Authenticate a client (login)
Route::post('/login', [AuthController::class, 'login']);

// Log the client out
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Get details of the logged-in user
Route::get('/logged-user', [AuthController::class, 'loggedUser'])->middleware('auth:sanctum');

/*
|--------------------------------------------------------------------------
| Agent Routes
|--------------------------------------------------------------------------
*/

// Register a new agent
Route::post('/agents', [AgentController::class, 'register']);

// Update an existing agent
Route::put('/agents/{id}', [AgentController::class, 'update']);

// Delete an existing agent
Route::delete('/agents/{id}', [AgentController::class, 'delete']);

// Get all agents
Route::get('/agents', [AgentController::class, 'all']);

// Get a specific agent by ID
Route::get('/agents/{id}', [AgentController::class, 'specific']);

/*
|--------------------------------------------------------------------------
| Property Routes
|--------------------------------------------------------------------------
*/

// Retrieve all properties
Route::get('/properties', [PropertyController::class, 'index']);

// Create a new property
Route::post('/properties', [PropertyController::class, 'store']);

// Retrieve a specific property by ID
Route::get('/properties/{id}', [PropertyController::class, 'show']);

// Update a specific property by ID
Route::put('/properties/{id}', [PropertyController::class, 'update']);

// Delete a specific property by ID
Route::delete('/properties/{id}', [PropertyController::class, 'destroy']);

/*
|--------------------------------------------------------------------------
| Offer Routes
|--------------------------------------------------------------------------
*/

// Retrieve all offers
Route::get('/offers', [OfferController::class, 'index']);

// Create a new offer
Route::post('/offers', [OfferController::class, 'store']);

// Retrieve a specific offer by ID
Route::get('/offers/{id}', [OfferController::class, 'show']);

// Update a specific offer by ID
Route::put('/offers/{id}', [OfferController::class, 'update']);

// Delete a specific offer by ID
Route::delete('/offers/{id}', [OfferController::class, 'destroy']);

/*
|--------------------------------------------------------------------------
| Category Routes
|--------------------------------------------------------------------------
*/

// Retrieve all categories
Route::get('/categories', [CategoryController::class, 'index']);

// Create a new category
Route::post('/categories', [CategoryController::class, 'store']);

// Retrieve a specific category by ID
Route::get('/categories/{id}', [CategoryController::class, 'show']);

// Update a specific category by ID
Route::put('/categories/{id}', [CategoryController::class, 'update']);

// Delete a specific category by ID
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

/*
|--------------------------------------------------------------------------
| Contact Routes
|--------------------------------------------------------------------------
*/

// Retrieve all contacts
Route::get('/contacts', [ContactController::class, 'index']);

// Create a new contact
Route::post('/contacts', [ContactController::class, 'store']);

// Retrieve a specific contact by ID
Route::get('/contacts/{id}', [ContactController::class, 'show']);

// Update a specific contact by ID
Route::put('/contacts/{id}', [ContactController::class, 'update']);

// Delete a specific contact by ID
Route::delete('/contacts/{id}', [ContactController::class, 'destroy']);
