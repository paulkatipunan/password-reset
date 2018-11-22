<?php

Route::group([    
    'namespace' => 'PaulKatipunan\Controllers',  
    'prefix' => 'password'
], function () {    
    Route::get('create/request/{email}', 'PasswordResetController@create')->name('request.email');
    Route::get('find/{token}', 'PasswordResetController@find')->name('find.token');
    Route::post('reset', 'PasswordResetController@reset')->name('update.password');
});
