<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        return view('user.details', ['user' => $user]);
    }
    public function submissions()
    {
        $user = Auth::user();
        return view('user.submissions', ['user' => $user]);
    }

    public function getSubmissions(Request $request, $id) {
        $user = User::find($id);

        return response()->json([
            'retCode' => 0,
            'retMsg' => 'OK',
            'result' =>$user->submissions
        ]);
    }

    public function get(Request $request, $id)
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
            'result' => $user
        ]);
    }

}
