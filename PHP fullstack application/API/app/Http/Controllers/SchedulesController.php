<?php

namespace App\Http\Controllers;

use App\Models\Schedules;
use Illuminate\Http\Request;

class SchedulesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = Schedules::all();
        return response()->json($schedules,200);
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $schedules = new Schedules();
        $schedules -> date = $request->input('date');
        $schedules -> state = $request->input('state');
        
        $schedules->save();

        return response()->json($schedules,201);
    }


    
    /**
     * Display the specified resource.
     */
    public function show(Schedules $schedules)
    {
        return response()->json($schedules,200);
    }

   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedules $schedules)
    {
        $schedules -> date = $request->input('date');
        $schedules -> state = $request->input('state');
        
        $schedules->save();

        return response()->json($schedules,201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedules $schedules)
    {
        $schedules->delete();

        return response()->json($schedules,200);
    }
}
