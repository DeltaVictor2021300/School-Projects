<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AppointmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
        //$appointments = Appointments::all();
        if (Auth::id() !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        return response()->json($user->appointments, 200);
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user)
    {
        if (Auth::id() !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $appointments = new Appointments();
        $appointments -> name = $request->input('name');
        $appointments -> phone = $request->input('phone');
        $appointments -> howdiduhearaboutus = $request->input('howdiduhearaboutus');
        $appointments -> date = $request->input('date');
        $appointments -> time = $request->input('time');
        $appointments -> specialist = $request->input('specialist');
        $appointments -> comment = $request->input('comment');
        $appointments -> user_id = Auth::id();
        
        $appointments->save();

        return response()->json($appointments,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user, Appointments $appointment)
    {
        if (Auth::id() !== $appointment->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        return response()->json($appointment,200);
    }

    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user, Appointments $appointment)
    {
        if (Auth::id() !== $appointment->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $appointment -> name = $request->input('name');
        $appointment -> phone = $request->input('phone');
        $appointment -> howdiduhearaboutus = $request->input('howdiduhearaboutus');
        $appointment -> date = $request->input('date');
        $appointment -> time = $request->input('time');
        $appointment -> specialist = $request->input('specialist');
        $appointment -> comment = $request->input('comment');
        $appointment -> user_id = Auth::id();
        
        $appointment->save();

        return response()->json($appointment,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, Appointments $appointment)
    {
        if (Auth::id() !== $appointment->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $appointment->delete();

        return response()->json($appointment,200);
    }
}
