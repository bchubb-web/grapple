<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', function (Request $request) {
    return json_encode(['foo' => 'bar']);
});

Route::get('/ping', function (Request $request) {
    http_response_code(200);
});
