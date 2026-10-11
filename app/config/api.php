<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------
 * LavaLust - an opensource lightweight PHP MVC Framework
 * ------------------------------------------------------------------
 */

/*
|--------------------------------------------------------------------------
| Enable/Disable API Helper
|--------------------------------------------------------------------------
*/

$config['api_helper_enabled'] = TRUE;

/*
|--------------------------------------------------------------------------
| Payload Token Expiration
|--------------------------------------------------------------------------
*/

$config['payload_token_expiration'] = 900;

/*
|--------------------------------------------------------------------------
| Refresh Token Expiration
|--------------------------------------------------------------------------
*/

$config['refresh_token_expiration'] = 604800;

/*
|--------------------------------------------------------------------------
| JWT Secret Token
|--------------------------------------------------------------------------
|
| Set JWT_SECRET in your environment.
|
*/

$config['jwt_secret'] = getenv('JWT_SECRET') ?: '';

/*
|--------------------------------------------------------------------------
| Refresh Token Key
|--------------------------------------------------------------------------
|
| Set REFRESH_TOKEN_KEY in your environment.
|
*/

$config['refresh_token_key'] = getenv('REFRESH_TOKEN_KEY') ?: '';

/*
|--------------------------------------------------------------------------
| API Administrator Credentials
|--------------------------------------------------------------------------
|
| Set API_ADMIN_USERNAME and API_ADMIN_PASSWORD_HASH in the environment.
| Generate the password hash with PHP's password_hash() function.
|
*/

$config['api_admin_username'] = getenv('API_ADMIN_USERNAME') ?: '';
$config['api_admin_password_hash'] = getenv('API_ADMIN_PASSWORD_HASH') ?: '';

/*
|--------------------------------------------------------------------------
| Access-Control-Allow-Origin
|--------------------------------------------------------------------------
|
| React frontend can run locally or from the deployed Render site.
|
*/

$config['allow_origin'] = [
    'http://localhost:5173',
    'https://lavalust-arban-frontend.onrender.com'
];

/*
|--------------------------------------------------------------------------
| Refresh Token Table
|--------------------------------------------------------------------------
*/

$config['refresh_token_table'] = 'refresh_tokens';

/*
|--------------------------------------------------------------------------
| JWT Issuer
|--------------------------------------------------------------------------
*/

$config['jwt_issuer'] = 'lavalust-lab6';

/*
|--------------------------------------------------------------------------
| JWT Audience
|--------------------------------------------------------------------------
*/

$config['jwt_audience'] = 'lavalust-frontend';

/*
|--------------------------------------------------------------------------
| Rate Limiting
|--------------------------------------------------------------------------
*/

$config['rate_limit_enabled'] = true;

/*
|--------------------------------------------------------------------------
| Rate Limiting Requests
|--------------------------------------------------------------------------
*/

$config['rate_limit_requests'] = 60;

/*
|--------------------------------------------------------------------------
| Rate Limiting Seconds
|--------------------------------------------------------------------------
*/

$config['rate_limit_seconds'] = 60;

?>