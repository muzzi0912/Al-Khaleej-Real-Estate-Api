<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\OfferController;




// Register a new client
Route::post('/register', [AuthController::class, 'register']);

// Authenticate a client (login)
Route::post('/login', [AuthController::class, 'login']);

// Log the client out
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Get details of the logged-in user
Route::get('/logged-user', [AuthController::class, 'loggedUser'])->middleware('auth:sanctum');



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




// CRUD routes for properties
Route::get('/properties', [PropertyController::class, 'index']);        
Route::post('/properties', [PropertyController::class, 'store']);     
Route::get('/properties/{id}', [PropertyController::class, 'show']);   
Route::put('/properties/{id}', [PropertyController::class, 'update']);  
Route::delete('/properties/{id}', [PropertyController::class, 'destroy']);


Route::get('/offers', [OfferController::class, 'index']);
Route::post('/offers', [OfferController::class, 'store']);
Route::get('/offers/{id}', [OfferController::class, 'show']);
Route::put('/offers/{id}', [OfferController::class, 'update']);
Route::delete('/offers/{id}', [OfferController::class, 'destroy']);