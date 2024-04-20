<?php

use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectCostController;
use Illuminate\Support\Facades\Route;

Route::controller(CurrencyController::class)->group(function () {
    Route::post("createCurrency", "createCurrency");
    Route::post("updateCurrency/{id}", "updateCurrency");
    Route::delete("deleteCurrency/{id}", "deleteCurrency");
    Route::get("getAllCurrency", "getAllCurrency");
    Route::get("getCurrencyWithPaginate", "getCurrencyWithPaginate");
    Route::get("chageMoney", "chageMoney");
    Route::get("getProjectCost/{id}", "getProjectCost");
    Route::get("getProjectCostWithCurrency/{id}", "getProjectCostWithCurrency");
});

Route::controller(ProjectController::class)->group(function () {
    Route::post("createProject", "createProject");
    Route::post("updateProject/{id}", "updateProject");
    Route::delete("deleteProject/{id}", "deleteProject");
    Route::get("getAllProject", "getAllProject");
    Route::get("getProjectWithPaginate", "getProjectWithPaginate");
});
Route::controller(ProjectCostController::class)->group(function () {
    Route::post("addCostToCurrentProject/{id}", "addCostToCurrentProject");
    Route::delete("deleteProjectCost/{id}", "deleteProjectCost");
});
