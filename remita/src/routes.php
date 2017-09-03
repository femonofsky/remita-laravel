<?php

Route::group(['namespace' => 'Femonofsky\Remita\Controllers', 'prefix'=>'remita'], function() {
    // Your route goes here
    Route::get('/', 'RemitaController@index');
    Route::get('initiateMandate', 'RemitaController@testMandate');
    Route::get('viewFormMandate/{mandateId}', 'RemitaController@testViewMandateForm');
    Route::get('stopMandate/{mandateId}/{requestId}', 'RemitaController@testStopMandate');
    Route::get('statusMandate/{requestId}', 'RemitaController@testStatusMandate');
    Route::get('historyMandate/{requestId}', 'RemitaController@testHistoryMandate');
    Route::get('paymentStatus/{RRR}', 'RemitaController@testPaymentStatusViaRRR');
    //  View Mandate Form
    http://www.remitademo.net/remita/ecomm/mandate/form/{merchantId}/{hash}/{mandateId}/{requestId}/rest.reg
});


