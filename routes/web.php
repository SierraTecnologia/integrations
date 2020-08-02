<?php

Route::group(
    ['middleware' => ['web']], function () {

        Route::prefix('integrations')->group(
            function () {
                Route::group(
                    ['as' => 'integrations.'], function () {

                        // /**
                        //  * 
                        //  */
                        // Route::get('home', 'HomeController@index')->name('home');
                        // Route::get('persons', 'HomeController@persons')->name('persons');

                        /**
                         * WebServices
                         */
                        Route::prefix('webservices')->group(
                            function () {
                                Route::namespace('WebServices')->group(
                                    function () {
                                        Route::group(
                                            ['as' => 'webservices.'], function () {

                                                Route::get('tokens', 'TokenController@index')->name('tokens.index');

                                            }
                                        );
                                    }
                                );
                            }
                        );

                    }
                );
            }
        );

    }
);