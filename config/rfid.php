<?php

return [

    /*
    |--------------------------------------------------------------------------
    | RFID API Key
    |--------------------------------------------------------------------------
    |
    | API key required for RFID scanner hardware to authenticate.
    | Generate with: php artisan key:generate --rfid
    |
    */

    'api_key' => env('RFID_API_KEY'),

];
