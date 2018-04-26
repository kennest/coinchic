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
    Route::get('/admin', ['as'=>'admin.index','uses'=>'adminController@index']);
    //ACCES AU FORMULAIRES
    Route::get('/form/place/{id?}', ['as'=>'form.place','uses'=>'adminController@placeForm']);
    Route::get('/form/event/{id?}', ['as'=>'form.event','uses'=>'adminController@eventForm']);


    Route::get('/delplace/{id?}', ['as'=>'place.delete','uses'=>'adminController@deletePlace']);
    Route::get('/delevent/{id?}', ['as'=>'event.delete','uses'=>'adminController@deleteEvent']);


//AJOUT ET MISE A JOUR
    Route::post('/addplace', ['as'=>'place.add','before' => 'csrf','uses'=>'adminController@addPlace']);
    Route::post('/addevent', ['as'=>'event.add','before' => 'csrf','uses'=>'adminController@addEvent']);

    Route::post('/updateplace', ['as'=>'place.update','before' => 'csrf','uses'=>'adminController@updatePlace']);
    Route::post('/updateevent', ['as'=>'event.update','before' => 'csrf','uses'=>'adminController@updateEvent']);
});



Route::group(['prefix' => 'api'], function ($route) {

    $route->get('/places/{type?}',['uses'=>'apiController@PlacesWithActiveEvents']);

    $route->get('/activeevents/{type?}',['uses'=>'apiController@allActiveEvents']);
    $route->get('/inactiveevents/{type?}',['uses'=>'apiController@allInactiveEvents']);
    $route->get('/placeshistory',['uses'=>'apiController@PlacesWithEvents']);
    $route->get('/similar/{word}',['uses'=>'apiController@SimilarEvents']);
    $route->get('/otheractiveevents/',['uses'=>'apiController@allOtherActiveEvents']);
    $route->get('/otherinactiveevents/',['uses'=>'apiController@allOtherInactiveEvents']);

    $route->get('/place/{id}',['uses'=>'clientController@getPlace']);
    $route->get('/event/{id}',['uses'=>'clientController@getEvent']);
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
