<?php

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
    return view('welcome');
});

Route::get('/home', function () {
    return redirect('dashboard');
});

Auth::routes(['register' => false]);

Route::middleware('auth')->group(function () {
    Route::middleware('profile')->group(function () {
        Route::get('/dashboard', 'DashboardController@index')->name('home');

        Route::group(['namespace' => 'Application'], function() {
            Route::group(['prefix' => 'application'], function() {
                // Route::get('/', 'ApplicationController@index')->middleware('permission:read-application');
                Route::get('/', 'ApplicationController@index')->name('application.index');
                Route::get('/create', 'ApplicationController@create')->name('application.create');
                Route::post('/', 'ApplicationController@store')->name('application.store');
                Route::get('/{application}', 'ApplicationController@show')->name('application.show');
                Route::get('/{application}/edit', 'ApplicationController@edit')->name('application.edit');
                Route::put('/{application}', 'ApplicationController@update')->name('application.update');
                Route::delete('/{application}', 'ApplicationController@destroy')->name('application.destroy');
                Route::post('approve/{application}', 'ApplicationController@approve')->name('application.approve');
                Route::get('reject/{application}', 'ApplicationController@reject')->name('application.reject');
            });
        });

        Route::group(['namespace' => 'Users'], function() {
            Route::group(['prefix' => 'users'], function() {
                Route::get('/', 'UserController@index')->name('users.index');
                Route::get('/create', 'UserController@create')->name('users.create');
                Route::post('/', 'UserController@store')->name('users.store');
                Route::get('/{user}', 'UserController@show')->name('users.show');
                Route::get('/{user}/edit', 'UserController@edit')->name('users.edit');
                Route::put('/{user}', 'UserController@update')->name('users.update');
                Route::delete('/{user}', 'UserController@destroy')->name('users.destroy');
            });
        });

        Route::group(['namespace' => 'Roles'], function() {
            Route::group(['prefix' => 'roles'], function() {
                Route::get('/', 'RoleController@index')->name('roles.index');
                Route::get('/create', 'RoleController@create')->name('roles.create');
                Route::post('/', 'RoleController@store')->name('roles.store');
                Route::get('/{role}', 'RoleController@show')->name('roles.show');
                Route::get('/{role}/edit', 'RoleController@edit')->name('roles.edit');
                Route::put('/{role}', 'RoleController@update')->name('roles.update');
                Route::delete('/{role}', 'RoleController@destroy')->name('roles.destroy');
            });
        });

        Route::group(['namespace' => 'Profile'], function() {
            Route::group(['prefix' => 'profile'], function() {
                Route::get('/', 'ProfileController@create')->name('profile.create');
                Route::post('/', 'ProfileController@store')->name('profile.store');
                Route::get('/{profile}/edit', 'ProfileController@edit')->name('profile.edit');
                Route::put('/{profile}', 'ProfileController@update')->name('profile.update');
            });
        });

        Route::group(['namespace' => 'Position'], function() {
            Route::group(['prefix' => 'position'], function() {
                Route::get('/', 'PositionController@index')->name('position.index')->middleware('permission:read-position');
                Route::get('/create', 'PositionController@create')->name('position.create')->middleware('permission:create-position');
                Route::post('/', 'PositionController@store')->name('position.store')->middleware('permission:create-position');
                Route::get('/{position}', 'PositionController@show')->name('position.show')->middleware('permission:read-position');
                Route::get('/{position}/edit', 'PositionController@edit')->name('position.edit')->middleware('permission:update-position');
                Route::put('/{position}', 'PositionController@update')->name('position.update')->middleware('permission:update-position');
                Route::delete('/{position}', 'PositionController@destroy')->name('position.destroy')->middleware('permission:delete-position');
            });
        });

        Route::group(['namespace' => 'Department'], function() {
            Route::group(['prefix' => 'department'], function() {
                Route::get('/', 'DepartmentController@index')->name('department.index')->middleware('permission:read-department');
                Route::get('/create', 'DepartmentController@create')->name('department.create')->middleware('permission:create-department');
                Route::post('/', 'DepartmentController@store')->name('department.store')->middleware('permission:create-department');
                Route::get('/{department}', 'DepartmentController@show')->name('department.show')->middleware('permission:read-department');
                Route::get('/{department}/edit', 'DepartmentController@edit')->name('department.edit')->middleware('permission:update-department');
                Route::put('/{department}', 'DepartmentController@update')->name('department.update')->middleware('permission:update-department');
                Route::delete('/{department}', 'DepartmentController@destroy')->name('department.destroy')->middleware('permission:delete-department');
            });
        });
    });
});