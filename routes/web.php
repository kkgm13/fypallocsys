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
        return redirect()->route('login');
    }
});

// Auth Routes with particular auth parameters removed
Auth::routes(['register' => false, 'reset' => false, 'verify' => false, 'confirm' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::resources([
    'topics' => 'TopicController',
    'proposals' => 'ProposalController',
]);

// Allocation Routing
Route::get('/allocations', 'AllocationController@index')->name('allocation.index');

// Choices Routing
Route::get('/my-choices', 'ChoiceController@index')->name('choices.mine');
Route::post('/topics/{topic}/select', 'ChoiceController@store')->name('choices.store');

// Decisions Routing
Route::get('/proposals/{proposal}/decision/', 'ProposalController@decision')->name('proposal.decision');
Route::post('/proposals/{proposal}/decision/', 'ProposalController@decision')->name('proposal.accepted');
Route::post('/proposals/{proposal}/decision/', 'ProposalController@decision')->name('proposal.rejected');
