<?php

use App\Http\Controllers\Praktikum\EloquentAdvancedController;
use App\Http\Controllers\Praktikum\EloquentCrudController;
use App\Http\Controllers\Praktikum\FormValidationController;
use App\Http\Controllers\Praktikum\QueryBuilderController;
use Illuminate\Support\Facades\Route;

Route::prefix('praktikum')->name('praktikum.')->group(function (): void {
    Route::prefix('query-builder')->name('query-builder.')->controller(QueryBuilderController::class)->group(function (): void {
        Route::get('/', 'index')->name('index');
        Route::post('/insert', 'insert')->name('insert');
        Route::post('/insert-get-id', 'insertGetId')->name('insert-get-id');
        Route::get('/get', 'get')->name('get');
        Route::get('/first', 'first')->name('first');
        Route::get('/where', 'where')->name('where');
        Route::get('/select', 'select')->name('select');
        Route::patch('/update/{id}', 'update')->name('update');
        Route::patch('/increment/{id}', 'increment')->name('increment');
        Route::patch('/decrement/{id}', 'decrement')->name('decrement');
        Route::delete('/delete/{id}', 'delete')->name('delete');
        Route::post('/truncate-orders', 'truncateOrders')->name('truncate-orders');
        Route::get('/pluck', 'pluck')->name('pluck');
        Route::get('/aggregates', 'aggregates')->name('aggregates');
        Route::get('/join', 'join')->name('join');
        Route::get('/left-join', 'leftJoin')->name('left-join');
        Route::get('/order-limit-offset', 'orderLimitOffset')->name('order-limit-offset');
        Route::get('/subquery', 'subquery')->name('subquery');
        Route::get('/raw', 'raw')->name('raw');
    });

    Route::prefix('eloquent-crud')->name('eloquent-crud.')->controller(EloquentCrudController::class)->group(function (): void {
        Route::post('/create', 'create')->name('create');
        Route::post('/save', 'save')->name('save');
        Route::get('/all', 'all')->name('all');
        Route::get('/find/{id}', 'find')->name('find');
        Route::get('/where', 'where')->name('where');
        Route::get('/first-or-fail', 'firstOrFail')->name('first-or-fail');
        Route::patch('/update/{id}', 'update')->name('update');
        Route::patch('/save-update/{id}', 'saveUpdate')->name('save-update');
        Route::delete('/delete/{id}', 'delete')->name('delete');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
    });

    Route::prefix('eloquent-advanced')->name('eloquent-advanced.')->controller(EloquentAdvancedController::class)->group(function (): void {
        Route::get('/where', 'where')->name('where');
        Route::get('/or-where', 'orWhere')->name('or-where');
        Route::get('/where-between', 'whereBetween')->name('where-between');
        Route::get('/where-in', 'whereIn')->name('where-in');
        Route::get('/where-null', 'whereNull')->name('where-null');
        Route::get('/where-not-null', 'whereNotNull')->name('where-not-null');
        Route::get('/when', 'when')->name('when');
        Route::get('/relation/{relation}', 'relation')->name('relation');
        Route::get('/with-trashed', 'withTrashed')->name('with-trashed');
        Route::get('/only-trashed', 'onlyTrashed')->name('only-trashed');
        Route::post('/restore/{id}', 'restore')->name('restore');
        Route::get('/active', 'active')->name('active');
    });

    Route::get('/form', [FormValidationController::class, 'showForm'])->name('form');
    Route::post('/form', [FormValidationController::class, 'submitForm'])->name('form.submit');
    Route::post('/form/request', [FormValidationController::class, 'submitRequest'])->name('form.request');
    Route::post('/form/uppercase', [FormValidationController::class, 'submitUppercase'])->name('form.uppercase');
});
