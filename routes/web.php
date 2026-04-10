<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return '<h1>ini adalah halaman tentang aplikasi event hub</h1>';
}); 

Route::get('/', function () {
    return view('welcome');
});

Route::get('/kontak', function () {
    return view('contact');
});

Route::get('/profil', function () {
    return view('profil');
});

Route::get('/katalog', function () {
    return view('katalog');
});

Route::get('/bantuan', function () {
    return view('bantuan');
});