<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserAuthController extends Controller
{
    public function login(Request $request){
        try{
            $data = $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);

            if (!auth()->attempt($data)) {
                return response(['error_message' => 'Incorrect Details. Please try again']);
            }

            $token = auth()->user()->createToken(env('APP_NAME'))->accessToken;

            return response()->json(['success' => true, 'token' => $token], 200);
        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function register(Request $request){
        try{
            $data = $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6'
            ]);
    
            $data['password'] = Hash::make($request->password);
    
            $user = User::create($data);
            RoleUser::create([
                'user_id' => $user->id,
                'role_id' => Role::USER_ROLE_ID
            ]);
    
            $token = $user->createToken(env('APP_NAME'))->accessToken;
    
            return response()->json(['success' => true, 'user' => $user, 'token' => $token], 200);
        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
