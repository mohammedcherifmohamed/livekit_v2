<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function show($roomName)
    {
        $user = auth()->user();
        
        // Generate a temporary token for the Next.js app
        $token = $user->createToken('handover_token')->plainTextToken;
        
        // Redirect to the Next.js app running on port 3000
        return redirect("http://localhost:3000/rooms/$roomName?token=$token");
    }
}
