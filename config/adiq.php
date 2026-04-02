<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Google Ad Manager OAuth2 Credentials
    |--------------------------------------------------------------------------
    |
    | These credentials are used to proxy the OAuth flow so publishers
    | never need their own Google Cloud project.
    |
    */

    'gam_client_id'     => env('GAM_CLIENT_ID', ''),
    'gam_client_secret' => env('GAM_CLIENT_SECRET', ''),
    'gam_redirect_uri'  => env('GAM_OAUTH_REDIRECT_URI', ''),

    /*
    |--------------------------------------------------------------------------
    | Google OAuth Scopes
    |--------------------------------------------------------------------------
    */

    'gam_scopes' => 'https://www.googleapis.com/auth/admanager email',

    /*
    |--------------------------------------------------------------------------
    | GAM API Base URL
    |--------------------------------------------------------------------------
    */

    'gam_api_base' => 'https://admanager.googleapis.com/v1',

];
