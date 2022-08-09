<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Nordigen API secret ID
    |--------------------------------------------------------------------------
    |
    | Enter your Nordigen API secret id for this app.
    |
    */
    'secret_id'   => env('NORDIGEN_SECRET_ID', ''),

    /*
    |--------------------------------------------------------------------------
    | Nordigen API secret key
    |--------------------------------------------------------------------------
    |
    | Enter your Nordigen PI secret key for this app.
    |
    */
    'secret_key'  => env('NORDIGEN_SECRET_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Should we use the Nordigen sandbox?
    |--------------------------------------------------------------------------
    |
    | If you wish to only use the Nordigen sandbox provider then set this to true.
    |
    */
    'use_sandbox' => env('NORDIGEN_USE_SANDBOX', false),
];
