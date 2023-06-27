<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    public function getUserNameById(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            // Handle case where user is not found
            return response()->json([
                'retCode' => 1,
                'retMsg' => 'User not found',
                'result' => null
            ], Response::HTTP_NOT_FOUND);
        }

        // User found, return the user data
        return response()->json([
            'retCode' => 0,
            'retMsg' => 'OK',
            'result' => $user->name
        ]);
    }
}
