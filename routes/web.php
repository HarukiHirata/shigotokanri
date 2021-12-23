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
    return view('top');
})->name('top');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin/login', function() {
    return view('/admin/login');
})->name('/admin/login');

Route::post('/admin/login', 'AdminController@adminlogin')->name('adminlogin');

Route::get('/admin/home', function() {
    return view('/admin/home');
})->name('/admin/home');

Route::get('/admin/logout', 'AdminController@adminlogout')->name('adminlogout');

Route::get('/employee/login', function() {
    return view('/employee/login');
})->name('/employee/login');

Route::post('/employee/login', 'EmployeeController@emplogin')->name('emplogin');

Route::get('/employee/home', function() {
    return view('/employee/home');
})->name('/employee/home');

Route::get('/employee/logout', 'EmployeeController@emplogout')->name('emplogout');

Route::get('/employee/attendance/create', 'AttendanceController@create');
Route::post('/employee/attendance/store', 'AttendanceController@store');
Route::get('/employee/attendance/edit/{id}', 'AttendanceController@edit');
Route::post('/attendance/update', 'AttendanceController@update');
Route::get('/employee/attendance/index', 'AttendanceController@index')->name('attendindex');
Route::post('/employee/attendance/index', 'AttendanceController@search');
Route::post('/attendance/destroy/{id}', 'AttendanceController@destroy');

Route::get('/admin/attendance/index', 'AttendanceController@companyindex')->name('attendindexbycmp');
Route::post('/admin/attendance/index', 'AttendanceController@searchforadmin');
Route::get('/admin/attendance/edit/{id}', 'AttendanceController@editforadmin');

Route::get('/admin/employeeregister', 'EmployeeController@create')->name('employeeregister');
Route::post('/admin/employeestore', 'EmployeeController@store');
Route::get('/admin/employeeindex', 'EmployeeController@index')->name('employeeindex');
Route::get('/admin/employeeedit/{id}', 'EmployeeController@edit')->name('employeeedit');
Route::post('/admin/employeeupdate', 'EmployeeController@update');
Route::post('/admin/employeedestroy/{id}', 'EmployeeController@destroy');

Route::get('/company/login', function() {
    return view('company.login');
})->name('/company/login');
Route::post('/company/login', 'CompanyController@companylogin')->name('companylogin');
Route::get('/company/home', 'AdminController@index')->name('/company/home');
Route::get('/company/logout', 'CompanyController@companylogout');

Route::get('/company/adminregister', 'AdminController@create')->name('adminregister');
Route::post('/company/adminstore', 'AdminController@store');
Route::get('/company/adminedit/{id}', 'AdminController@edit')->name('adminedit');
Route::post('/company/adminupdate', 'AdminController@update');
Route::post('/company/admindestroy/{id}', 'AdminController@destroy');

Route::get('/company/register', 'CompanyController@create');
Route::post('/company/store', 'CompanyController@store');