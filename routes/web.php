<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

    return view('auth/login');

})->middleware('guest');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//---------------- routes for task management----------

Route::prefix('task')->group(function()
{
    Route::post('/create','TaskController@create')->name('create_task');

    Route::delete('/delete/{taskid}','TaskController@destroy')->name('delete_task');

    Route::get('/update/{taskid}' , 'TaskController@show_to_update')->name('show_to_update');

    Route::post('/update/{taskid}', 'TaskController@update')->name('update_task');
   
    Route::get('/comment/{taskid}', 'TaskController@show_to_comment')->name('show_to_comment');

    Route::post('/createcomment/{taskid}', 'TaskController@create_comment')->name('create_comment');

    }
);

Route::prefix('archive')->group(function()
{
    Route::get('/{taskid}', 'TaskController@archive')->name('archive_task');

    Route::get('/', 'TaskController@show_archive')->name('show_archive')->middleware('auth');

    Route::delete('/delete/{taskid}','TaskController@destroy_archived')->name('delete_archive_task');

    Route::get('/restore/{taskid}', 'TaskController@restore_task')->name('restore_task')->middleware('auth');

    }
);



