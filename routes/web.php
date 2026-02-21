<?php

use Illuminate\Support\Facades\Route;

Route::get('admin/users', 'Admin\UserController@index')->name('admin.users.index');
Route::get('admin/users/create', 'Admin\UserController@create')->name('admin.users.create');
Route::post('admin/users', 'Admin\UserController@store')->name('admin.users.store');
Route::get('admin/users/{user}', 'Admin\UserController@show')->name('admin.users.show');
Route::get('admin/users/{user}/edit', 'Admin\UserController@edit')->name('admin.users.edit');
Route::put('admin/users/{user}', 'Admin\UserController@update')->name('admin.users.update');
Route::delete('admin/users/{user}', 'Admin\UserController@destroy')->name('admin.users.destroy');
