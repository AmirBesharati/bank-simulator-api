<?php
return [
    'response_statuses' => [
        'success' => 200 , //OK
        'no_content' => 204 , //No Content
        'bad_request' => 400 , //Bad request
        'unauthorized' => 401 , //Unauthorized or unauthenticated
        'forbidden' => 403 , //Permission denied
        'not_found' => 404 , //Not found
        'method_not_allowed' => 405  , //Method not allowed
        'unprocessable_entity' => 422  , //Method not allowed
    ] ,


    'account_types' => [
        [
            'title' => 'Saving Account' ,
            'start_balance' => 10000
        ]  ,
        [
            'title' => 'Checking Account' ,
            'start_balance' => 20000
        ]  ,
        [
            'title' => 'Money Market Account' ,
            'start_balance' => 30000
        ]  ,
        [
            'title' => 'Certificate of Deposit (CD)' ,
            'start_balance' => 40000
        ]  ,
    ] ,


    'transaction_types' => [
        [
            'title' => 'Internal Transfer' ,
//            'fee' => '' ,
//            'fee_type' => '' ,
        ]  ,
        [
            'title' => 'cash withdrawals or deposits' ,
//            'fee' => '' ,
//            'fee_type' => '' ,
        ]  ,
        [
            'title' => 'checks' ,
//            'fee' => '' ,
//            'fee_type' => '' ,
        ]  ,
        [
            'title' => 'online payments' ,
//            'fee' => '' ,
//            'fee_type' => '' ,
        ]  ,
        [
            'title' => 'debit card charges' ,
//            'fee' => '' ,
//            'fee_type' => '' ,
        ]  ,
        [
            'title' => 'loan payments' ,
//            'fee' => '' ,
//            'fee_type' => '' ,
        ]  ,
    ] ,


];
