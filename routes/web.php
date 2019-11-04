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
    if(Auth::user()){
        return redirect()->route('home');
    } else {
        return view('auth.login');
    }
});

// Auth Routes with particular auth parameters removed
Auth::routes(['register' => false, 'reset' => false, 'verify' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::resources([
    'topics' => 'TopicController'
]);