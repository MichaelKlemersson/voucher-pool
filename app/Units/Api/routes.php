<?php

$router->group(['prefix' => 'v1'], function ($router) {
    // Offers
    $router->group([
        'prefix' => 'offers',
        'namespace' => 'Offers'
    ], function ($router) {
        $router->get('/', ['as' => 'api.offers.list', 'uses' => 'OfferController@index']);
        $router->post('/', ['as' => 'api.offers.create', 'uses' => 'OfferController@store']);
    });

    // Recipients
    $router->group([
        'prefix' => 'recipients',
        'namespace' => 'Recipients'
    ], function ($router) {
        $router->get('/', ['as' => 'api.recipients.list', 'uses' => 'RecipientController@index']);
        $router->post('/', ['as' => 'api.recipients.create', 'uses' => 'RecipientController@store']);
    });

    // Vouchers
    $router->group([
        'prefix' => 'vouchers',
        'namespace' => 'Vouchers'
    ], function ($router) {
        $router->post('/generate', ['as' => 'api.vouchers.generate', 'uses' => 'VoucherController@generate']);
        $router->get('/check', ['as' => 'api.vouchers.check', 'uses' => 'VoucherController@check']);
        $router->get('/from-recipient', [
            'as' => 'api.vouchers.from_recipient',
            'uses' => 'VoucherController@getRecipientVouchers'
        ]);
    });
});
