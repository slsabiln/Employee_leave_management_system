<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('welcome');
});

Route::get('locale/{lang}', function ($lang) {
    if (in_array($lang, ['en', 'ar'])) {
        App::setLocale($lang);
    }
    return redirect()->back();
})->name('locale.switch');

Route::get('/locale/{lang}', function ($lang) {
    if (in_array($lang, ['en', 'ar'])) {
        App::setLocale($lang);
        Session::put('locale', $lang);
    }
    return redirect()->back();
})->name('locale.switch');
/*
Route::get('locale/{locale}', function ($locale) {
    session(['locale' => $locale]);
    app()->setLocale($locale);
    return redirect()->back();
})->name('locale.switch');
*/
