<?php


if (\Muleta\Modules\Features\Resources\FeatureHelper::hasActiveFeature(
    [
        'integrations',
        'services',
    ]
)){
    Route::resource('/tokens', 'TokenController')->parameters([
        'tokens' => 'id'
    ]);
}