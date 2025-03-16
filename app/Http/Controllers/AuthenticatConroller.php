<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticatConroller extends Controller
{
    public function get_data(){
        try{
            return User::select('id','name', 'email', 'password', 'google_id', 'apple_id', 'facebook_id', 'phone',  'country_of_citizenship',  'country_of_birth',  'date_of_birth',  'national_ID',  'identity_proof',  'country_of_issue',  'date_of_expiry',  'residential_address',  'role')->get();
        }catch(Exception $e){
            return response()->json([
               'message' => 'An error occurred while processing the request',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function register(Request $request){
        try{
            $validate_data = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
                'residential_address' => 'sometimes|string',
                'role' => 'sometimes|in:buyer,seller,admin'
            ]);
            
            // User::where('email', $request->email)->exists();

            $validate_data['password'] = hash::make( $request->password);

            $user = User::create($validate_data);

            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user,
                'token' => $user->createToken('auth_token')->plainTextToken
            ], 201);
        }
        catch(\Exception $e){
            return response()->json([
               'message' => 'Register failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function login(Request $request){
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string' // لا تستخدم 'password' كقاعدة هنا
            ]);

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'message' => 'Login failed'
                ], 401);
            }

            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Login failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function logout(Request $request)
    {
        
        try{
            $request->user()->currentAccessToken()->delete();
        
            return response()->json([
                'message' => 'logged out'
            ]);
        }catch(Exception $e){
            return response()->json([
               'message' => 'An error occurred while processing the request',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function updateProfile(Request $request){
        try{
            $user = $request->user();
            if (!$user) {
                return response()->json([
                    'message' => 'Unauthenticated. Please log in first.'
                ], 401);
            }

            
            $validatedData = $request->validate([
                
                'name' => 'sometimes|string',
                'email' => 'sometimes|email|unique:users,email,' . $user->id,
                'password' => 'sometimes|min:6',
                'phone' => 'sometimes|max:20',
                'residential_address' => 'sometimes|string',
                'role' => 'sometimes|in:buyer,seller,admin',
                'date_of_birth' => 'sometimes|date'
            ]);

            
            if ($request->has('password')) {
                $validatedData['password'] = Hash::make($request->password);
            }

            
            $user->update($validatedData);

            return response()->json([
                'user' => $user,
                'message' => 'Profile updated successfully'
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'message' => 'An error occurred while processing the request',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    function deleteProfile(){
        try{
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                'message' => 'Unauthenticated. Please log in first.'
                ], 401);
            }

            
            $user->delete();

            return response()->json([
            'message' => 'User deleted successfully'
            ]);
        }catch(\Exception $e){
            return response()->json([
               'message' => 'An error occurred while processing the request',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function Change_role(Request $request){
        try{
            $user = $request->user();
            if (!$user) {
                return response()->json([
                    'message' => 'Unauthenticated. Please log in first.'
                ], 401);
            }

            

            
            $validatedData = $request->validate([
                'phone' => 'required|string',  
                'country_of_citizenship' => 'required|string',  
                'country_of_birth' => 'required|string',  
                'date_of_birth' => 'required|date',  
                'national_ID' => 'required|string',  
                'identity_proof' => 'required|string',   
                'country_of_issue' => 'required|string',  
                'date_of_expiry' => 'required|date',
                'card_Number' => 'required|string',
                'date_expires_card' => 'required|string',	
                'card_holder_name' => 'required|string',
                'residential_address' => 'required|string'
            ]);

            


            
            $user->update($validatedData);

            return response()->json([
                'user' => $user,
                'message' => 'Profile updated successfully'
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'message' => 'An error occurred while processing the request',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function get_user(Request $request){
        try {
            $credentials = $request->validate([
                'id' => 'required|integer|exists:users,id'
            ]);



            $user = Auth::user();

            return response()->json([
                'message' => 'fetching successful',
                'user' => $user
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Login failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
