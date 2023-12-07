<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class AuthController extends Controller
{
   
public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email', // Check for unique email
        'password' => 'required|min:6',
    ]);

    if ($validator->fails()) {
        return response()->json(['message' => 'Invalid input', 'errors' => $validator->errors()], 422);
    }

    $user = User::create([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'password' => Hash::make($request->input('password')),
    ]);

    return response()->json([
        'status' => true,
        'message' => 'User Created Successfully',
        'token' => $user->createToken("API_TOKEN")->plainTextToken
    ], 201); // 201 Created status code for successful resource creation
}

    public function login(Request $req)
        {
            $rules = [
                'email'=>'required|email',
                 'password'=>'required'
            ];

            $authenticatedUser = Validator::make($req->all(), $rules);

            if($authenticatedUser->fails())
                {
                    return response()->json(['message'=>'Invalid Credentials','status'=>401]);
                }

             $user = User::where('email',$req->email)->first();
             if ($user && Hash::check($req->password, $user->password)) {
                // Authentication successful
                $token = $user->createToken('API TOKEN')->plainTextToken;
        
                return response()->json([
                    'status' => true,
                    'message' => 'User logged in successfully',
                    'token' => $token,
                ], 200);
            }
            else{
                return response()->json(['message'=>'User not found']);
            }
                
        }
        
        public function logout(Request $request)
        {
            $user = $request->user();
        
            if (!$user) {
                // If the user is not authenticated, return an error response
                return response()->json([
                    'status' => false,
                    'message' => 'User not authenticated',
                ], 401);
            }
        
            // Check if the provided token matches the user's current access token
            if ($request->token === $user->currentAccessToken()->plainTextToken) {
                // Revoke the user's current access token
                $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        
                return response()->json([
                    'status' => true,
                    'message' => 'User logged out successfully',
                ], 200);
            }
        
            // If the provided token does not match, return an error response
            return response()->json([
                'status' => false,
                'message' => 'Invalid token provided',
            ], 401);
        }

   
           
}
