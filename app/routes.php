<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */

Route::group(array('before' => 'auth'), function() {
    Route::get('/', function() {
        $environment = App::environment();
        return View::make('master');
    });
    Route::controller('statistik', 'ListenerController');
    Route::controller('artist', 'ArtistController');
    Route::controller('song', 'SongController');
    Route::controller('genre', 'GenreController');
    Route::controller('ruangsiar', 'RuangsiarController');
    Route::resource('banner', 'BannerResource');
    Route::resource('program', 'ProgramResource');

    //API
    Route::get('api/playlist', 'ApiController@playlist');
    Route::get('api/hitslist', 'ApiController@hitslist');
    Route::get('api/newsong', 'ApiController@getnewsong');
    Route::get('api/likedmember/{id}', 'ApiController@likedmember');
    Route::get('api/program/change/{id}', 'ApiController@programChange');
    Route::get('api/listeners/{id}', 'ApiController@listeners');
    Route::get('api/nosong/{id}', 'ApiController@nosong');
    Route::get('api/ignore/list', 'ApiController@ignoreList');
    Route::get('api/ignore/{id}/remove', 'ApiController@ignoreRemove');
    Route::get('api/ignore/removeall', 'ApiController@ignoreRemoveAll');
    Route::get('api/ignore/{id}', 'ApiController@ignore');
    Route::get('api/newsong/{id}', 'ApiController@newsong');
    Route::get('api/chart/{id}', 'ApiController@chart');
    Route::get('api/similarartist/{id}', 'ApiController@similar_artist');
    Route::get('api/similargenre/{id}/artistid/{artist_id}', 'ApiController@similar_genre');
    Route::get('api/similaryear/{year}/artistid/{artist_id}', 'ApiController@similar_year');
});

Route::get('login', array('uses' => 'LoginController@showLogin'));
Route::post('login', array('uses' => 'LoginController@doLogin'));
Route::get('logout', array('uses' => 'LoginController@doLogout'));


