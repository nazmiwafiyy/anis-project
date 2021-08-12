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
    // return view('welcome');
    return redirect('login');
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
                Route::get('/', 'ApplicationController@index')->name('application.index')->middleware('permission:read-application');
                Route::get('/create', 'ApplicationController@create')->name('application.create')->middleware('permission:create-application');
                Route::post('/', 'ApplicationController@store')->name('application.store')->middleware('permission:create-application');
                Route::get('/{application}', 'ApplicationController@show')->name('application.show')->middleware('permission:read-application');
                // Route::get('/{application}/edit', 'ApplicationController@edit')->name('application.edit')->middleware('permission:update-application');
                // Route::put('/{application}', 'ApplicationController@update')->name('application.update')->middleware('permission:update-application');
                Route::delete('/{application}', 'ApplicationController@destroy')->name('application.destroy')->middleware('permission:delete-application');
                Route::post('approve/{application}', 'ApplicationController@approve')->name('application.approve');
                Route::get('reject/{application}', 'ApplicationController@reject')->name('application.reject');

            });

            Route::group(['prefix' => 'approval'], function() {
                Route::get('/', 'ApprovalController@index')->name('approval.index')->middleware('permission:read-approval');
                Route::get('/{approval}', 'ApprovalController@show')->name('approval.show')->middleware('permission:read-approval');
                Route::delete('/{approval}', 'ApprovalController@destroy')->name('approval.destroy')->middleware('permission:delete-approval');
            });
        });

        Route::group(['namespace' => 'Users'], function() {
            Route::group(['prefix' => 'users'], function() {
                Route::get('/', 'UserController@index')->name('users.index')->middleware('permission:read-users');
                Route::get('/create', 'UserController@create')->name('users.create')->middleware('permission:create-users');
                Route::post('/', 'UserController@store')->name('users.store')->middleware('permission:create-users');
                Route::get('/{user}', 'UserController@show')->name('users.show')->middleware('permission:read-users');
                Route::get('/{user}/edit', 'UserController@edit')->name('users.edit')->middleware('permission:update-users');
                Route::put('/{user}', 'UserController@update')->name('users.update')->middleware('permission:update-users');
                Route::delete('/{user}', 'UserController@destroy')->name('users.destroy')->middleware('permission:delete-users');
            });
        });

        Route::group(['namespace' => 'Roles'], function() {
            Route::group(['prefix' => 'roles'], function() {
                Route::get('/', 'RoleController@index')->name('roles.index')->middleware('permission:read-roles');
                Route::get('/create', 'RoleController@create')->name('roles.create')->middleware('permission:create-roles');
                Route::post('/', 'RoleController@store')->name('roles.store')->middleware('permission:create-roles');
                Route::get('/{role}', 'RoleController@show')->name('roles.show')->middleware('permission:read-roles');
                Route::get('/{role}/edit', 'RoleController@edit')->name('roles.edit')->middleware('permission:update-roles');
                Route::put('/{role}', 'RoleController@update')->name('roles.update')->middleware('permission:update-roles');
                Route::delete('/{role}', 'RoleController@destroy')->name('roles.destroy')->middleware('permission:delete-roles');
            });
        });

        Route::group(['namespace' => 'Profile'], function() {
            Route::group(['prefix' => 'profile'], function() {
                Route::get('/', 'ProfileController@create')->name('profile.create')->middleware('permission:update-profile');
                // Route::post('/', 'ProfileController@store')->name('profile.store')->middleware('permission:create-profile');
                Route::get('/{profile}/edit', 'ProfileController@edit')->name('profile.edit')->middleware('permission:update-profile');
                Route::put('/{profile}', 'ProfileController@update')->name('profile.update')->middleware('permission:update-profile');

                Route::get('/change-password', 'ProfileController@editPassword')->name('profile.edit-password')->middleware('permission:update-profile-password');
                Route::post('/change-password', 'ProfileController@updatePassword')->name('profile.update-password')->middleware('permission:update-profile-password');
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

        Route::group(['namespace' => 'Type'], function() {
            Route::group(['prefix' => 'type'], function() {
                Route::get('/', 'TypeController@index')->name('type.index')->middleware('permission:read-type');
                Route::get('/{type}', 'TypeController@show')->name('type.show')->middleware('permission:read-type');
                Route::get('/{type}/edit', 'TypeController@edit')->name('type.edit')->middleware('permission:update-type');
                Route::put('/{type}', 'TypeController@update')->name('type.update')->middleware('permission:update-type');
            });
        });

    });
});