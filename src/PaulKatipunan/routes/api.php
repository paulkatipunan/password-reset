<?php

Route::group([    
    'namespace' => 'PaulKatipunan',  
    'prefix' => 'password'
], function () {    
    Route::post('create/request', 'PasswordResetController@create')->name('request.email');
    Route::get('find/{token}', 'PasswordResetController@find')->name('find.token');
    Route::post('reset', 'PasswordResetController@reset')->name('update.password');
});
