<?php

namespace App\Http\Controllers;

use App\Models\ClinicHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ClinicHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
        if (Auth::id() !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        return response()->json($user->clinic_histories,200);
    }

   //create deleted because we work with an API
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user)
    {
        if (Auth::id() !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $clinicHistory = new ClinicHistory();
        $clinicHistory -> birth_date = $request->input('birth_date');
        $clinicHistory -> gender = $request->input('gender');
        $clinicHistory -> phone = $request->input('phone');
        $clinicHistory -> address = $request->input('address');
        $clinicHistory -> city = $request->input('city');
        $clinicHistory -> email = $request->input('email');
        $clinicHistory -> medical_conditions = $request->input('medical_conditions');
        $clinicHistory -> current_medications = $request->input('current_medications');
        $clinicHistory -> allergies = $request->input('allergies');
        $clinicHistory -> personal_habits = $request->input('personal_habits');
        $clinicHistory -> frequency_visits = $request->input('frequency_visits');
        $clinicHistory -> user_id = Auth::id();
        $clinicHistory->save();

        return response()->json($clinicHistory,201);
    }

     /**
     * Display the specified resource.
     */
    public function show(User $user, ClinicHistory $clinicHistory)
    {
        if (Auth::id() !== $clinicHistory->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        return response()->json($clinicHistory,200);
    }

    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user, ClinicHistory $clinicHistory)
    {
        if (Auth::id() !== $clinicHistory->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $clinicHistory -> birth_date = $request->input('birth_date');
        $clinicHistory -> gender = $request->input('gender');
        $clinicHistory -> phone = $request->input('phone');
        $clinicHistory -> address = $request->input('address');
        $clinicHistory -> city = $request->input('city');
        $clinicHistory -> email = $request->input('email');
        $clinicHistory -> medical_conditions = $request->input('medical_conditions');
        $clinicHistory -> current_medications = $request->input('current_medications');
        $clinicHistory -> allergies = $request->input('allergies');
        $clinicHistory -> personal_habits = $request->input('personal_habits');
        $clinicHistory -> frequency_visits = $request->input('frequency_visits');
        $clinicHistory->save();

        return response()->json($clinicHistory,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, ClinicHistory $clinicHistory)
    {
        if (Auth::id() !== $clinicHistory->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $clinicHistory->delete();

        return response()->json($clinicHistory,200);
    }
}
