<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return redirect()->route('books.index');
});

Route::resource('books', 'Books\\BooksController')->except([
    'create', 'show',
]);

Route::get('books/export/{type}', 'Books\\ExportController');
