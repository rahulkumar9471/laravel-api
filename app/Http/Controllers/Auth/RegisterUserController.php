<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class RegisterUserController extends Controller
{
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'type' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'mobile' => ['required', 'numeric', 'digits_between:10,12', 'unique:users,mobile'],
            'password' => ['required', 'max: 8']
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Validation failed', 'error' => $validator->errors()]);
        }

        try {

            $user = User::create([
                'type' => $request->type,
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => password_hash($request->password, PASSWORD_DEFAULT),
            ]);

            if ($user) {
                return response()->json(['status' => 'success', 'message' => 'Register Successfully', 'user' => $user]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to register']);
            }

        } catch (\Throwable $th) {
            \Log::error('User registration failed: ' . $th->getMessage());
            return response()->json(['status' => 'error', 'message' => 'An error occurred during registration. Please try again later.']);
        }

    }


    public function show()
    {

        try {

            $users = User::orderBy('id', 'DESC')->get();

            if (!$users) {
                return response()->json(['status' => 'fail', 'message' => 'Users not found']);
            }

            return response()->json(['status' => 'success', 'user' => $users]);

        } catch (\Throwable $th) {
            \Log::error('User Show failed: ' . $th->getMessage());
            return response()->json(['status' => 'error', 'message' => 'An error occurred during Show. Please try again later.']);
        }

    }


    public function user($id)
    {

        try {

            $user = User::find($id);

            if (!$user) {
                return response()->json(['status' => 'fail', 'message' => 'User not found']);
            }

            return response()->json(['status' => 'success', 'user' => $user]);

        } catch (\Throwable $th) {
            \Log::error('User find failed: ' . $th->getMessage());
            return response()->json(['status' => 'error', 'message' => 'An error occurred during find user. Please try again later.']);
        }

    }

    public function update($id, Request $request)
    {

    }

    public function destroy($id)
    {

        try {

            $user = User::find($id);

            if (!$user) {
                return response()->json(['status' => 'fail', 'message' => 'User not found']);
            }

            $destroyUser = $user->delete();

            if (!$destroyUser) {
                return response()->json(['status' => 'fail', 'message' => 'User not Deleted.']);
            }

            return response()->json(['status' => 'success', 'message' => 'User Delete Successfully', 'user' => $user]);

        } catch (\Throwable $th) {
            \Log::error('User find failed: ' . $th->getMessage());
            return response()->json(['status' => 'error', 'message' => 'An error occurred during find user. Please try again later.']);
        }

    }

}
