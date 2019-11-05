<?php

use App\Events\GiveLocation;
use Illuminate\Http\Request;

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

Route::post('map/location', function (Request $request) {
    $lat = $request->lat;
    $lon = $request->lon;

    $location = ["lat"=>$lat, "lon"=>$lon];

    event(new GiveLocation($location));
    return response()->json(["status"=>"success","data"=>$location]);
});

Auth::routes();


//HOME PAGE
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');
Route::post('/register/passenger', 'HomeController@register')->name('registerUser');
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('/location', 'LocationController@index')->name('location');

//DRIVERS
Route::get('/drivers', 'DriverController@index')->name('drivers');
Route::get('/drivers/create', 'DriverController@create')->name('createDriver');
Route::post('/drivers/save', 'DriverController@store')->name('saveDriver');
Route::get('/drivers/show/{id}', 'DriverController@show')->name('showDriver');
Route::get('/drivers/edit/{id}', 'DriverController@edit')->name('editDriver');
Route::post('/drivers/update/{id}', 'DriverController@update')->name('updateDriver');
Route::get('/drivers/delete/{id}', 'DriverController@destroy')->name('deleteDriver');

//ASSIGN BUS
Route::get('/drivers/assign-bus-page/{id}', 'DriverController@assignBusPage')->name('assignBusPageDriver');
Route::post('/drivers/assign-driver/{id}', 'DriverController@assignBus')->name('assignDriver');
Route::get('/drivers/unassign-driver/{id}', 'DriverController@unassignBus')->name('unassignBus');

//GENERATE REPORTS
Route::post('/drivers/print-driver-report', 'DriverController@export')->name('print-driver-report');

//CHANGE PASSWORD
Route::get('/settings/change-password-page', 'SettingController@changePasswordPage')->name('changePasswordPage');
Route::post('/settings/change-password', 'SettingController@changePassword')->name('changePassword');

//BUSES
Route::get('/buses', 'BusController@index')->name('buses');
Route::get('/buses/create', 'BusController@create')->name('createBus');
Route::post('/buses/save', 'BusController@store')->name('saveBus');
Route::get('/buses/show/{id}', 'BusController@show')->name('showBus');
Route::get('/buses/edit/{id}', 'BusController@edit')->name('editBus');
Route::post('/buses/update/{id}', 'BusController@update')->name('updateBus');
Route::get('/buses/delete/{id}', 'BusController@destroy')->name('deleteBus');

//ASSIGN TRIP
Route::get('/buses/assign-trip-page/{id}', 'BusController@assignTripPage')->name('assignTripPage');
Route::post('/buses/assign-trip/{id}', 'BusController@assignTrip')->name('assignTrip');

//PASSENGERS
Route::get('/passengers', 'PassengerController@index')->name('passengers');
Route::get('/passengers/create', 'PassengerController@create')->name('createPassenger');
Route::post('/passengers/save', 'PassengerController@store')->name('savePassenger');
Route::get('/passengers/show/{id}', 'PassengerController@show')->name('showPassenger');
Route::get('/passengers/edit/{id}', 'PassengerController@edit')->name('editPassenger');
Route::post('/passengers/update/{id}', 'PassengerController@update')->name('updatePassenger');
Route::get('/passengers/delete/{id}', 'PassengerController@destroy')->name('deletePassenger');

//TRIPS
Route::get('/trips', 'TripController@index')->name('trips');
Route::get('/trips/create', 'TripController@create')->name('createTrip');
Route::post('/trips/save', 'TripController@store')->name('saveTrip');
Route::get('/trips/show/{id}', 'TripController@show')->name('showTrip');
Route::get('/trips/edit/{id}', 'TripController@edit')->name('editTrip');
Route::post('/trips/update/{id}', 'TripController@update')->name('updateTrip');
Route::get('/trips/delete/{id}', 'TripController@destroy')->name('deleteTrip');

//START END TRIP
Route::get('/trips/start/{id}', 'TripController@start')->name('startTrip');
Route::get('/trips/end/{id}', 'TripController@end')->name('endTrip');

//Location Tracking IP Address
Route::get('get/track-location', 'LocationController@getLocation')->name("getLocation");
Route::post('post/track-location', 'LocationController@postLocation')->name("postLocation");

//
Route::get('/user/profile', 'UserController@profile')->name('profile');
