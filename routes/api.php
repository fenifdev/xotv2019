<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('total_videos_size_by_user', 'VideosController@total_videos_size_by_user');
Route::get('videos/{id_video}/metadata', 'VideosController@video_metadata');
Route::patch('videos/{id_video}/metadata', 'VideosController@update_video_metadata');
//Route::patch('update_video_metadata', 'VideosController@update_video_metadata');
