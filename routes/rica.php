<?php

Route::group(
    ['middleware' => ['web']],
    function () {

        // /**
        //  *
        //  */
        // Route::get('home', 'HomeController@index')->name('home');
        // Route::get('persons', 'HomeController@persons')->name('persons');

        /**
         * WebServicos
         */
        Route::prefix('webservicos')->group(
            function () {
                Route::namespace('WebServicos')->group(
                    function () {
                        Route::group(
                            ['as' => 'webservicos.'],
                            function () {
                                Route::get('tokens', 'TokenController@index')->name('tokens.index');
                            }
                        );
                    }
                );
            }
        );
    }
);
