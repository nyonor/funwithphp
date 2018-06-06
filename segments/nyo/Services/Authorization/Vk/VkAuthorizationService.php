<?php
/**
 * Реализует интерфейс авторизации OAuth 2.0 (?)
 * для авторизации пользователей через удаленный АПИ vk.com
 *
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/22/18
 * Time: 11:48 AM
 */

namespace Segments\Nyo\Services\Authorization\Vk;


use App\Services\ServiceException;
use Exception;
use VK\Client\VKApiClient;
use VK\Exceptions\VKApiException;
use VK\Exceptions\VKClientException;
use VK\OAuth\VKOAuth;

class VkAuthorizationService implements VkAuthorizationServiceInterface
{
    protected $vkApi;
    protected $auth;

    public function __construct(VKApiClient $client, VKOAuth $auth)
    {
        $this->vkApi = $client;
        $this->auth = $auth;
    }

    /**
     * Защищённый ключ приложения в ВК
     * @see https://vk.com/editapp?id=6486588&section=options
     */
    protected const CLIENT_SECRET_KEY = 'CwgexX8h7X8xTbCR8iLX';

    /**
     * Шаблон адреса страницы, куда должен быть перенаправлен пользователь для входа в ВК
     * @see https://vk.com/dev/authcode_flow_user?f=1.%20%D0%9E%D1%82%D0%BA%D1%80%D1%8B%D1%82%D0%B8%D0%B5%20%D0%B4%D0%B8%D0%B0%D0%BB%D0%BE%D0%B3%D0%B0%20%D0%B0%D0%B2%D1%82%D0%BE%D1%80%D0%B8%D0%B7%D0%B0%D1%86%D0%B8%D0%B8
     */
    protected const AUTHORIZATION_DIALOG_URL_TEMPLATE = "https://oauth.vk.com/authorize?client_id=%u&display=%s&redirect_uri=%s&response_type=code&v=5.76&state=authorized";

    /**
     * Шаблон адреса на который будет передан code
     * @see https://vk.com/dev/authcode_flow_user?f=1.%20%D0%9E%D1%82%D0%BA%D1%80%D1%8B%D1%82%D0%B8%D0%B5%20%D0%B4%D0%B8%D0%B0%D0%BB%D0%BE%D0%B3%D0%B0%20%D0%B0%D0%B2%D1%82%D0%BE%D1%80%D0%B8%D0%B7%D0%B0%D1%86%D0%B8%D0%B8
     */
    protected const REDIRECT_URI = "http://localhost:8080/authorization/vk";

    /**
     * Шаблон адреса по которому необходимо запросить access_token
     * @see https://vk.com/dev/authcode_flow_user?f=4.%20%D0%9F%D0%BE%D0%BB%D1%83%D1%87%D0%B5%D0%BD%D0%B8%D0%B5%20access_token
     */
    protected const ACCESS_TOKEN_URL = "https://oauth.vk.com/access_token?client_id=%u&client_secret=%s&redirect_uri=%s&code=%s";

    /**
     * ID зарегистрированного приложения в VK
     * @see https://vk.com/editapp?id=6486588&section=options
     */
    protected const APP_ID = 6486588;

    /**
     * Тип отображения страницы куда куда будет перенаправлен пользователья для входа в ВК
     * может быть:
     * page — форма авторизации в отдельном окне;
     * popup — всплывающее окно;
     * mobile — авторизация для мобильных устройств (без использования Javascript)
     * @var string $authDialogDisplayType
     */
    protected $authDialogDisplayType = 'page';

    /**
     * После успешной авторизации приложения браузер пользователя будет
     * перенаправлен по адресу redirect_uri, указанному при открытии диалога авторизации.
     * При этом код для получения ключа доступа code будет передан как GET-параметр
     *
     * Это тот самый код
     *
     * @var string $authCode
     * @see https://vk.com/dev/authcode_flow_user?f=1.%20%D0%9E%D1%82%D0%BA%D1%80%D1%8B%D1%82%D0%B8%D0%B5%20%D0%B4%D0%B8%D0%B0%D0%BB%D0%BE%D0%B3%D0%B0%20%D0%B0%D0%B2%D1%82%D0%BE%D1%80%D0%B8%D0%B7%D0%B0%D1%86%D0%B8%D0%B8
     */
    protected $authCode;

    /**
     * Получить адрес переадресации на основании параметров
     *
     * @param $app_id
     * @param $auth_dialog_display_type
     * @param $redirect_uri
     * @return string
     */
    protected function authorizationDialogUrl($app_id, $auth_dialog_display_type, $redirect_uri)
    {
        return sprintf(self::AUTHORIZATION_DIALOG_URL_TEMPLATE, $app_id, $auth_dialog_display_type, $redirect_uri);
    }

    /**
     * Получить адрес для получения access_token
     *
     * @param $app_id
     * @param $client_secret_key
     * @param $redirect_uri
     * @param $auth_code
     * @return string
     */
    protected function accessTokenUrl($app_id, $client_secret_key, $redirect_uri, $auth_code)
    {
        return sprintf(self::ACCESS_TOKEN_URL, $app_id, $client_secret_key, $redirect_uri, $auth_code);
    }

    /**
     * Получить адрес переадресации на основании параметров
     * для получения $authCode
     *
     * @return string
     */
    public function getAuthorizationDialogUrl()
    {
        return $this->authorizationDialogUrl(self::APP_ID, $this->authDialogDisplayType, self::REDIRECT_URI);
    }

    /**
     * Получить access_token и vk_user_id
     * на основании $auth_code
     *
     * @param null $auth_code
     * @return array
     * @throws ServiceException
     * @see https://vk.com/dev/authcode_flow_user?f=4.%20%D0%9F%D0%BE%D0%BB%D1%83%D1%87%D0%B5%D0%BD%D0%B8%D0%B5%20access_token
     * @throws Exception
     */
    public function getAccessTokenAndUserId($auth_code = null) : array
    {
        if (empty($auth_code) == false) {
            $this->authCode = $auth_code;
        }

        if (empty($this->authCode)) {
            throw new ServiceException('To get access token you must provide the code!');
        }

        try{
            $answer = $this->auth->getAccessToken(self::APP_ID, self::CLIENT_SECRET_KEY,
                self::REDIRECT_URI, $auth_code);
        } catch (Exception $e) {
            throw new ServiceException($e);
        }

        if (empty($answer)) {
            throw new ServiceException('Cannot get access_token!');
        }

        return [
            'access_token'  => $answer->access_token,
            'user_id'       => $answer->user_id
        ];
    }

    /**
     * Проверить соответствует ли переданный access_token
     * vk_user_id. access_token должен быть действующим иначе будет возвращен false
     *
     * @param $vk_user_id
     * @param $access_token
     * @return mixed
     */
    public function checkIsValid($vk_user_id, $access_token)
    {
        try {
            $check_result = $this->vkApi->secure()->checkToken($access_token);

            if ($check_result->success != 1) {
                return false;
            }

            if ($check_result->user_id != $vk_user_id) {
                return false;
            }

            if ($check_result->expire > time()) {
                return false;
            }
        } catch (VKApiException $e) {
            return false;
        } catch (VKClientException $e) {
            return false;
        }
    }
}