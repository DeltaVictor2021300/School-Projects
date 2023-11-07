<?php

namespace App\Http\Controllers;

use App\Models\TypeUser;
use Illuminate\Http\Request;

class TypeUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typeUser = TypeUser::all();
        return response()->json($typeUser,200);
    }

   
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $typeUser = new TypeUser();
        $typeUser -> description = $request->input('description');
        $typeUser -> state = $request->input('state');
        
        $typeUser->save();

        return response()->json($typeUser,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(TypeUser $typeUser)
    {
        return response()->json($typeUser,200);
    }

    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TypeUser $typeUser)
    {
        $typeUser -> description = $request->input('description');
        $typeUser -> state = $request->input('state');
        
        $typeUser->save();

        return response()->json($typeUser,201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeUser $typeUser)
    {
        $typeUser->delete();

        return response()->json($typeUser,200);
    }
}
