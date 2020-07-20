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

                        // /**
                        //  * Track
                        //  */
                        // Route::prefix('track')->group(
                        //     function () {
                        //         Route::namespace('Track')->group(
                        //             function () {
                        //                 Route::group(
                        //                     ['as' => 'track.'], function () {

                        //                         Route::get('person', 'PersonController@index')->name('person');

                        //                     }
                        //                 );
                        //             }
                        //         );
                        //     }
                        // );

                    }
                );
            }
        );

    }
);