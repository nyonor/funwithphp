<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/22/18
 * Time: 11:48 AM
 */

namespace Segments\Nyo\Model\Services\Authorization\Vk;


use Exception;

class VkAuthorizationService implements VkAuthorizationServiceInterface
{
    protected const CLIENT_SECRET_KEY = 'CwgexX8h7X8xTbCR8iLX';
    protected const AUTHORIZATION_DIALOG_URL_TEMPLATE = "https://oauth.vk.com/authorize?client_id=%u&display=%s&redirect_uri=%s&response_type=code&v=5.76&state=authorized";
    protected const REDIRECT_URI = "http://localhost:8080/authorization/vk";
    protected const ACCESS_TOKEN_URL = "https://oauth.vk.com/access_token?client_id=%u&client_secret=%s&redirect_uri=%s&code=%s";
    protected const APP_ID = 6486588;

    protected $authDialogDisplayType = 'page';
    protected $authCode;

    protected function authorizationDialogUrl($app_id, $auth_dialog_display_type, $redirect_uri)
    {
        return sprintf(self::AUTHORIZATION_DIALOG_URL_TEMPLATE, $app_id, $auth_dialog_display_type, $redirect_uri);
    }

    protected function accessTokenUrl($app_id, $client_secret_key, $redirect_uri, $auth_code)
    {
        return sprintf(self::ACCESS_TOKEN_URL, $app_id, $client_secret_key, $redirect_uri, $auth_code);
    }

    public function getAuthorizationDialogUrl()
    {
        return $this->authorizationDialogUrl(self::APP_ID, $this->authDialogDisplayType, self::REDIRECT_URI);
    }

    public function getAccessToken($auth_code = null)
    {
        if (empty($auth_code) == false) {
            $this->authCode = $auth_code;
        }

        if (empty($this->authCode)) {
            throw new Exception('To get access token you must provide the code!');
        }

        $access_token_url = $this->accessTokenUrl(self::APP_ID, self::CLIENT_SECRET_KEY,
            self::REDIRECT_URI, $this->authCode);

        $access_token = json_decode(file_get_contents($access_token_url));

        return $access_token;
    }
}