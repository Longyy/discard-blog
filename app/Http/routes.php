<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function() {
    return redirect('/blog');
});

Route::get('blog', 'BlogController@index');
Route::get('blog/{slug}', 'BlogController@showPost');

// admin area
Route::get('admin', function(){
    return redirect('/admin/post');
});

Route::group(['namespace' => 'Admin', 'middleware' => 'auth'], function() {
    resource('admin/post', 'PostController', ['except' => 'show']);
    resource('admin/tag', 'TagController', ['except' => 'show']);
    Route::get('admin/upload', 'UploadController@index');

    post('admin/upload/file', 'UploadController@uploadFile');
    delete('admin/upload/file', 'UploadController@deleteFile');
    post('admin/upload/folder', 'UploadController@createFolder');
    delete('admin/upload/folder', 'UploadController@deleteFolder');
});

// Logging in and out
Route::get('/auth/login', 'Auth\AuthController@getLogin');
Route::post('/auth/login', 'Auth\AuthController@postLogin');
Route::get('/auth/logout', 'Auth\AuthController@getLogout');

