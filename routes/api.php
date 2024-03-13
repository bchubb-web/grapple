<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Site;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/ping', function (Request $request) {
    http_response_code(200);
});

Route::get('/site', function (Request $request) {
    return Site::all();
});

Route::post('/site', function (Request $request) {
    $site_info = json_decode($request->getContent(), true);

    $site = new Site(['name' => $site_info['name'], 'repo_url' => $site_info['repo_url']]);

    if (Site::query()->where('name', $site_info['name'])->exists()) {
        return request()->json(['message' => 'Site already exists'], 409);
    }

    if (!$site->save()) {
        return request()->json(['message' => 'Site creation failed'], 500);
    }
    return request()->json(['message' => 'Site created'], 201);
});

Route::get('/site/{site}/deployments', function (Request $request, Site $site) {
    return $site->deployments()->get();
});



Route::post('/deploy', function (Request $request) {
    $deployment = json_decode($request->getContent(), true);

    $site = Site::query()->find($deployment['site_id']);

    $site->deployments()->create([
        'site_id' => $deployment['site_id'],
        'commit' => $deployment['commit'],
        'branch' => $deployment['branch'],
        'live' => $deployment['live'],
    ]);

    return request()->json(['message' => 'Deployment created'], 201);
});

