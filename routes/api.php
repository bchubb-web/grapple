<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Models\Site;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', function (Request $request) {
    return json_encode(['foo' => 'bar']);
});

Route::get('/ping', function (Request $request) {
    http_response_code(200);
});

Route::get('/site', function (Request $request) {
    return Site::all('name');
});

Route::post('/site', function (Request $request) {
    $site_info = json_decode($request->getContent(), true);

    $site = new Site(['name' => $site_info['name'], 'repo_url' => $site_info['repo_url']]);
    if (!$site->save()) {
        http_response_code(500);
    }
});
