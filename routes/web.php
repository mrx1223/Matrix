<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/", function () {
    return "Here";
});
Route::get("getImage/{id}/{file_name}", function ($id, $file_name) {
    $path = public_path("media/$id/$file_name");
    if (file_exists($path)) {
        return response()->file($path);
    } else {
        abort(404);
    }
});

Route::any('/*', function () {
    return response("not found");
});
