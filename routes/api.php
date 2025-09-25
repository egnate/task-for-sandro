<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\NotesController;
use App\Models\User;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Login endpoint to get API token
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'token_name' => 'string|max:255'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }

    $tokenName = $request->token_name ?? 'API Token';
    $token = $user->createToken($tokenName);

    return response()->json([
        'token' => $token->plainTextToken,
        'token_name' => $tokenName,
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ],
        'message' => 'Login successful'
    ]);
});

// Generate API token for authenticated users
Route::post('/tokens/create', function (Request $request) {
    $request->validate([
        'token_name' => 'required|string|max:255',
    ]);

    $token = $request->user()->createToken($request->token_name);

    return response()->json([
        'token' => $token->plainTextToken,
        'token_name' => $request->token_name,
        'message' => 'Token created successfully'
    ]);
})->middleware('auth:sanctum');

// Notes API endpoints
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/notes', [NotesController::class, 'store']);
    Route::get('/notes', [NotesController::class, 'index']);
});

// Public endpoints
Route::get('/published/{slug}', [NotesController::class, 'show']);