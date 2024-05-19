<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agent;

class AgentController extends Controller
{
    /**
     * Register a new agent.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // Validation rules
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:agents,email',
            'phone_number' => 'required|string',
            'license_number' => 'required|string|unique:agents,license_number',
            'commission_percentage' => 'required|numeric',
        ]);

        // Create the agent
        $agent = Agent::create($request->all());

        return response()->json(['agent' => $agent], 201);
    }

    /**
     * Update the specified agent.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Find the agent
        $agent = Agent::findOrFail($id);

        // Validation rules
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:agents,email,' . $agent->id,
            'phone_number' => 'required|string',
            'license_number' => 'required|string|unique:agents,license_number,' . $agent->id,
            'commission_percentage' => 'required|numeric',
        ]);

        // Update the agent
        $agent->update($request->all());

        return response()->json(['agent' => $agent], 200);
    }

    /**
     * Delete the specified agent.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        // Find the agent
        $agent = Agent::findOrFail($id);

        // Delete the agent
        $agent->delete();

        return response()->json(['message' => 'Agent deleted successfully'], 200);
    }

    /**
     * Display a listing of the agents.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        // Retrieve all agents
        $agents = Agent::all();

        return response()->json(['agents' => $agents], 200);
    }

    /**
     * Display the specified agent.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function specific($id)
    {
        // Find the agent
        $agent = Agent::findOrFail($id);

        return response()->json(['agent' => $agent], 200);
    }
}
