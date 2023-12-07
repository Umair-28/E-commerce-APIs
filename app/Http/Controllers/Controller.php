<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;



class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function getAllUsers() // Get all users from database
        {
            $users = User::all();
            return response()->json($users);
        }

        public function getUserById($id)  // Find a user by its ID
        {
            $user = User::find($id);
            return response()->json($user);
        } 
        
    public function deleteUserById($id)  // Delete a user by its ID
        {
            User::destroy($id);
            return response('User with $id ID is deleted');
        }    
        
    
        public function updateUserById(Request $req,  $id) // Update user data with specific ID
        {
            $user = User::findOrFail($id);
            $user->update($req->all());
            return response('User is Updated Successfully');
        }        
}
