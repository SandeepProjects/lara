<?php

namespace App\Http\Controllers;

use Illumniate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserStoreRequest;


class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json([
            'results' => $users
        ], 200);
    }


    public function show($id)
    {
        $users = User::find($id);
        if (!$users) {
            return response()->json([
                'message' => 'User not found.'
            ], 404);
        }

        return response()->json([
            'users' => $users
        ], 200);
    }


    public function store(UserStoreRequest $request)
    {
        try {
            // Create user with hashed password
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);

            return response()->json([
                'message' => "User successfully created."
            ], 200);  // Use HTTP status code 201 for resource creation success
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Something Went Wrong!!",
                'error' => $e->getMessage()  // Optionally include the error message
            ], 500);
        }
    }

    public function update(UserStoreRequest $request, $id)
    {
        try {
            $users = User::find($id);
            if (!$users) {
                return $users()->json([
                    'message' => 'Users not found!'
                ], 404);
            }

            $users->name = $request->name;
            $users->email = $request->email;
            $users->password = $request->password;

            $users->save();

            return response()->json([
                'message' => "User Successfully updated."
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something Went really Wrong!'
            ], 500);
        }
    }
}
