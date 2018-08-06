<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();

Route::get('', function(){
    if(Auth::check()){
        return redirect()->route('admin');
    }else{
        return redirect()->route('login');
    }
});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'auth.role:employer'], function(){

    // Accounts
    Route::get('', 'DashboardController@index')->name('admin');
    
    // Account Groups
    Route::get('account-groups/all/{id?}', 'AccountGroupController@all')->name('account-groups.all');
    Route::post('account-groups/send', 'AccountGroupController@send')->name('account-groups.send');
    Route::post('account-groups', 'AccountGroupController@save')->name('account-groups.store');
    Route::delete('account-groups/{id}', 'AccountGroupController@destroy')->name('account-groups.destroy');

    // Projects
    Route::get('projects/can-create', function(){
        $can = (Auth::user()->hasRole('employer'))? 'no': 'yes';
        
        return response($can);
    });
    Route::get('client/{id}', 'ProjectController@clientProjects')->name('projects.client');
    Route::get('projects/all/{client?}', 'ProjectController@allProjects')->name('projects.all');
    Route::resource('projects', 'ProjectController');

    // Profile
    Route::get('profile/{user}/edit', 'UserController@profileEdit')->name('profile.edit');
    Route::put('profile/{user}', 'UserController@profileUpdate')->name('profile.update');

    // Password
    Route::get('password/{user}/edit', 'UserController@passwordEdit')->name('password.edit');
    Route::put('password/{user}', 'UserController@passwordUpdate')->name('password.update');
    
});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'auth.role:manager'], function(){    

    // Clients
    Route::get('clients/all', 'ClientController@allClients')->name('clients.all');
    Route::resource('clients', 'ClientController');    
    
    // Categories
    Route::get('categories', 'CategoryController@index')->name('categories.index');
    Route::get('categories/all', 'CategoryController@all')->name('categories.all');
    Route::post('categories', 'CategoryController@updateAll')->name('categories.update');
    
});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'auth.role:admin'], function(){

    // Users
    Route::get('users/all', 'UserController@allUsers')->name('users.all');
    Route::resource('users', 'UserController');
    
    // Settings
    Route::get('settings/all', 'SettingsController@all')->name('settings.all');
    Route::get('settings', 'SettingsController@index')->name('settings.index');
    Route::put('settings', 'SettingsController@update')->name('settings.update');

});

