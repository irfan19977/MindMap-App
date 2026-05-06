<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.index');
});

Route::get('/about', function () {
    return view('frontend.about');
});

Route::get('/kelas', function () {
    return view('frontend.kelas');
});

Route::get('/mindmap', function () {
    return view('frontend.mindmap');
});

Route::get('/materi/{slug}', function ($slug) {
    return view('frontend.materi-detail', ['slug' => $slug]);
});

Route::get('/contact', function () {
    return view('frontend.contact');
});
