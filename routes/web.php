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
    return "නමෝ බුද්ධාය!";
});

Route::group(['prefix'=>'latest_videos'],function(){
    Route::get('/youtube/{count?}','Post\PostController@youtube_videos')->where('count', '[0-9]+');
    Route::get('/facebook/{count?}','Post\PostController@facebook_videos')->where('count', '[0-9]+');
    Route::get('/vimeo/{count?}','Post\PostController@vimeo_videos')->where('count', '[0-9]+');
    Route::get('/{count?}','Post\PostController@latest_videos_count')->where('count', '[0-9]+');
});

Route::get('video/{id}', 'Post\PostController@singleVideo')->where('id', '[0-9]+');

// get livestram id
Route::get('live_id', 'Youtube\YoutubeControlle@liveStream');

// Test Route

Route::get('testdata','Temp\TempController@returnPortfolio');
Route::get('newsfeed','Notifications\NewsFeedController@getNewsFeed');
// Route::get('test01','Post\PostController@test01');

// Banner Route
Route::get('notifications/banners', 'Notifications\BannerController@getBanners');

Route::get('documentation','Documentation\DocumentationController@documentation');


/*
|--------------------------------------------------------------------------
| New Routes
|--------------------------------------------------------------------------
|
*/

// Updates
Route::group(['prefix'=>'updates'], function () {
    Route::get('/videos/{count?}', 'Updates\UpdatesController@videos')->where('count', '[0-9]+');
    Route::get('/news/{count?}', 'Updates\UpdatesController@news')->where('count', '[0-9]+');
    Route::get('/audios/{count?}', 'Updates\UpdatesController@audios')->where('count', '[0-9]+');
});

// Single Post
Route::get('post/{id}', 'Post\SinglePostController@singlePost');