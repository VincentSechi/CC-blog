<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
Route::get('/', function () {
    return view('index');
});

Route::prefix('articles')->name('articles.')->group(function () {
    Route::get('/', [ArticleController::class, 'index'])->name('index');
    Route::get('/ajouter', [ArticleController::class, 'create'])->name('create');
    Route::post('/ajouter', [ArticleController::class, 'store'])->name('store');
    Route::get('/modifier/{article}', [ArticleController::class, 'edit'])->name('edit');
    Route::post('/modifier/{article}', [ArticleController::class, 'update'])->name('update');
    Route::delete('/supprimer/{article}', [ArticleController::class, 'destroy'])->name('destroy');
    Route::get('{article}', [ArticleController::class, 'show'])->name('show');
    Route::get('liste_par_categorie/{categoryName}', [ArticleController::class, 'filterByCategory'])->name('filterByCategory');
});
Route::post('/articles/{article}/comments', [CommentController::class, 'store'])->name('comments.store');

Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::get('/ajouter', [CategoryController::class, 'create'])->name('create');
    Route::post('/ajouter', [CategoryController::class, 'store'])->name('store');
});
 