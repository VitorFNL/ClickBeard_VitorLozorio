<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/users', function (Request $request) {
    // This route returns a list of users.
    return response()->json([
        'message' => 'List of users'
    ]);
});