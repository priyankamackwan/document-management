<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:api']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::post('users/media', 'UsersApiController@storeMedia')->name('users.storeMedia');
    Route::apiResource('users', 'UsersApiController');

    // Document Types
    Route::apiResource('document-types', 'DocumentTypesApiController');

    // Documents
    Route::post('documents/media', 'DocumentsApiController@storeMedia')->name('documents.storeMedia');
    Route::apiResource('documents', 'DocumentsApiController');

    //get logged in user detail
    Route::get('/user', function (Request $request){ 
        return auth()->guard('api')->user();
    });
});

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin'], function () {
    Route::post('register', 'UsersApiController@store')->name('register.store');
});

