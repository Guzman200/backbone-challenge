<?php

return [

    /*
    |--------------------------------------------------------------------------
    | OpenPay Environment VARIABLES
    |--------------------------------------------------------------------------
    |
    | There are variables from OpenPay variables.
    |
    */
    
    // Pagos
    'openpay_ID' => env('OPENPAY_ID', ''),
    'openpay_SK' => env('OPENPAY_SK', ''),
    'openpay_production_mode' => env('OPENPAY_PRODUCTION_MODE', 'false'),
    'openpay_enviroment_env' => env('OPENPAY_ENVIROMENT', ''),
   
];