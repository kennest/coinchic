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
Route::group(['middleware'=>'auth'],function (){
    Route::get('/', ['as'=>'admin.index','uses'=>'adminController@index']);
    //ACCES AU FORMULAIRES
    Route::get('/form/artist/{id?}', ['as'=>'form.artist','uses'=>'adminController@artistForm']);
    Route::get('/form/place/{id?}', ['as'=>'form.place','uses'=>'adminController@placeForm']);
    Route::get('/form/event/{id?}', ['as'=>'form.event','uses'=>'adminController@eventForm']);


    Route::get('/delartist/{id?}', ['as'=>'artist.delete','uses'=>'adminController@deleteArtist']);
    Route::get('/delplace/{id?}', ['as'=>'place.delete','uses'=>'adminController@deletePlace']);
    Route::get('/delevent/{id?}', ['as'=>'event.delete','uses'=>'adminController@deleteEvent']);


//AJOUT ET MISE A JOUR
    Route::post('/addartist', ['as'=>'artist.add','before' => 'csrf','uses'=>'adminController@addArtist']);
    Route::post('/addplace', ['as'=>'place.add','before' => 'csrf','uses'=>'adminController@addPlace']);
    Route::post('/addevent', ['as'=>'event.add','before' => 'csrf','uses'=>'adminController@addEvent']);

    Route::post('/updateartist', ['as'=>'artist.update','before' => 'csrf','uses'=>'adminController@updateArtist']);
    Route::post('/updateplace', ['as'=>'place.update','before' => 'csrf','uses'=>'adminController@updatePlace']);
    Route::post('/updateevent', ['as'=>'event.update','before' => 'csrf','uses'=>'adminController@updateEvent']);
});



Route::group(['prefix' => 'api'], function ($route) {

    $route->get('/places/{type?}',['uses'=>'clientController@PlacesWithActiveEvents']);
    $route->get('/artists',['uses'=>'clientController@ArtistsWithEvents']);

    $route->get('/activeevents/{type?}',['uses'=>'clientController@allActiveEvents']);
    $route->get('/inactiveevents/{type?}',['uses'=>'clientController@allInactiveEvents']);
    $route->get('/placeshistory',['uses'=>'clientController@PlacesWithEvents']);
    $route->get('/similar/{word}',['uses'=>'clientController@SimilarEvents']);
    $route->get('/otheractiveevents/',['uses'=>'clientController@allOtherActiveEvents']);
    $route->get('/otherinactiveevents/',['uses'=>'clientController@allOtherInactiveEvents']);


    $route->get('/artist/{id}',['uses'=>'clientController@getArtist']);
    $route->get('/place/{id}',['uses'=>'clientController@getPlace']);
    $route->get('/event/{id}',['uses'=>'clientController@getEvent']);
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
