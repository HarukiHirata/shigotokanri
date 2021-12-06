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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin/login', function() {
    return view('/admin/login');
});

Route::post('/admin/login', 'AdminController@adminlogin')->name('adminlogin');

Route::get('/admin/home', function() {
    return view('/admin/home');
});

Route::get('/admin/logout', 'AdminController@adminlogout')->name('adminlogout');

Route::get('/employee/login', function() {
    return view('/employee/login');
});

Route::post('/employee/login', 'EmployeeController@emplogin')->name('emplogin');

Route::get('/employee/home', function() {
    return view('/employee/home');
});

Route::get('/employee/logout', 'EmployeeController@emplogout')->name('emplogout');