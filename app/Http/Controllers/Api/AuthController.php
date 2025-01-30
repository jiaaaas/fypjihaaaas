<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
     public function login(Request $request)
     {
     $validator = Validator::make($request->all(), [
     'username' => 'required|email',
     'password' => 'required',
     'client_id' => 'required',
     'client_secret' => 'required',
     ]);

     if ($validator->fails()) {
     return response()->json(['error' => $validator->errors()], 401);
     }

     $response = Http::asForm()->post(url('/oauth/token'), [
     'grant_type' => 'password',
     'username' => $request->username,
     'password' => $request->password,
     'client_id' => $request->client_id,
     'client_secret' => $request->client_secret,
     ]);

    if ($response->successful()) {
    $token = $response->json();
    $employee = Employee::where('email', $request->email)->first();

    return response()->json([
    'id' => $employee->id,
    'name' => $employee->name,
    'email' => $employee->email,
    'token_type' => $token['token_type'],
    'expires_in' => $token['expires_in'],
    'access_token' => $token['access_token'],
    'refresh_token' => $token['refresh_token'],
    ]);
    }

    // Handle unsuccessful authentication
    return response()->json([
    'message' => 'Unauthenticated',
    'error' => $response->json()
    ], 401);
     }
}