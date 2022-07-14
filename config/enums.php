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
        'CREATE_ACCOUNT' => [
            'id' => 1 ,
            'title' => 'Create Account Reward' ,
//            'fee' => '' ,
//            'fee_type' => '' ,
        ]  ,
        'INTERNAL' => [
            'id' => 2 ,
            'title' => 'Internal Transfer' ,
//            'fee' => '' ,
//            'fee_type' => '' ,
        ]  ,
        'EXTERNAL' => [
            'id' => 3 ,
            'title' => 'External Transfer' ,
//            'fee' => '' ,
//            'fee_type' => '' ,
        ]  ,
    ] ,


];
