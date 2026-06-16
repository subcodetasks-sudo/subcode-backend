<?php

use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sitemap.xml', [SitemapController::class, 'index']);
Route::get('/pages-{locale}.xml', [SitemapController::class, 'pages'])->whereIn('locale', ['ar', 'en', 'tr']);
Route::get('/posts-{locale}.xml', [SitemapController::class, 'posts'])->whereIn('locale', ['ar', 'en', 'tr']);
