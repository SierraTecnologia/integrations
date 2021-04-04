<?php

Route::resource('/tokens', 'TokenController')->parameters([
    'tokens' => 'id'
]);