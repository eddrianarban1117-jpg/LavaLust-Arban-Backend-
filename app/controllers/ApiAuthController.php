<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ApiAuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->call->library('api');
    }

    public function login()
    {
        $this->api->require_method('POST');
        $this->api->rate_limit();

        $input = $this->api->body(false);

        $username = is_string($input['username'] ?? null)
            ? trim($input['username'])
            : '';
        $password = is_string($input['password'] ?? null)
            ? $input['password']
            : '';
        $configured_username = config_item('api_admin_username') ?? '';
        $password_hash = config_item('api_admin_password_hash') ?? '';

        if ($configured_username === '' || $password_hash === '') {
            $this->api->respond_error('API login is not configured.', 503);
            return;
        }

        if (
            !hash_equals($configured_username, $username) ||
            !password_verify($password, $password_hash)
        ) {
            $this->api->respond_error(
                'Invalid username or password.',
                401
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Generate JWT Access + Refresh Tokens
        |--------------------------------------------------------------------------
        |
        | The API library requires a user ID.
        | User ID 1 is used for the Lab 6 admin account.
        |
        */

        $tokens = $this->api->issue_tokens([
            'id' => 1,
            'role' => 'admin',
            'scopes' => [
                'read',
                'write'
            ]
        ]);

        $this->api->respond([
            'status' => true,
            'message' => 'Login successful.',
            'user' => [
                'id' => 1,
                'username' => $username,
                'role' => 'admin'
            ],
            'tokens' => $tokens
        ]);
    }

    public function refresh()
    {
        $this->api->require_method('POST');
        $this->api->rate_limit();

        $input = $this->api->body();
        $refresh_token = $input['refresh_token'] ?? '';

        if (!is_string($refresh_token) || $refresh_token === '') {
            $this->api->respond_error('Refresh token is required.', 400);
            return;
        }

        $this->api->refresh_access_token($refresh_token);
    }

    public function logout()
    {
        $this->api->require_method('POST');

        $input = $this->api->body();
        $refresh_token = $input['refresh_token'] ?? '';
        $payload = is_string($refresh_token)
            ? $this->api->validate_jwt($refresh_token)
            : null;

        if (!$payload || ($payload['type'] ?? '') !== 'refresh') {
            $this->api->respond_error('Invalid refresh token.', 401);
            return;
        }

        $this->api->revoke_refresh_token($refresh_token);

        $this->api->respond([
            'status' => true,
            'message' => 'Logout successful.'
        ]);
    }
}
?>