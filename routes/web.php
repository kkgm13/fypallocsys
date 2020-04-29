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

// Route Resources with pre-defeined CRUD
Route::resources([
    'users' => 'UserController',
    'topics' => 'TopicController',
    'proposals' => 'ProposalController',
    'choices' => 'ChoiceController',
]);

// Allocation Custom Routing
Route::get('/allocations', 'AllocationController@index')->name('allocations.index');
Route::get('/allocations/unallocated/students', 'AllocationController@unallocatedStudent')->name('allocations.unallocatedStudent');
Route::get('/allocations/unallocated/topics', 'AllocationController@unallocatedTopic')->name('allocations.unallocatedTopic');

// Choices Custom Routing
Route::get('/my-choices', 'ChoiceController@index')->name('choices.mine');
Route::post('/topics/{topic}/select', 'ChoiceController@store')->name('choices.store');
    // Form Bypass
Route::get('topics/{topic}/select', 'ChoiceController@store')->name('choices.store');
Route::post('/topics/{topic}/deselect', 'ChoiceController@destroy')->name('choices.destroy');
    // Form Bypass
Route::get('topics/{topic}/deselect', 'ChoiceController@destroy')->name('choices.destroy');
Route::delete('/topics/{topic}/deselect', 'ChoiceController@destroy')->name('choices.destroy');

// Decisions Custom Routing
Route::post('/proposals/{proposal}/decision/', 'ProposalController@decision')->name('proposals.decision');
Route::post('/topics/{topic}/allocate', 'TopicController@allocate')->name('topics.allocate');
