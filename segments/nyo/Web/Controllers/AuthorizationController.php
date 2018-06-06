<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/21/18
 * Time: 3:58 PM
 */

namespace Segments\Nyo\Web\Controllers;


use App\Http\Session;
use App\Ioc\Ioc;
use App\Modules\Mvc\Controller\AbstractMvcController;
use App\Services\ServiceException;
use Segments\Nyo\Services\Authorization\AuthorizationService;
use Segments\Nyo\Services\Authorization\AuthorizationServiceInterface;
use Segments\Nyo\Services\Authorization\AuthorizationTypeEnum;
use Segments\Nyo\Services\Authorization\Vk\VkAuthorizationService;
use Segments\Nyo\Services\Authorization\Vk\VkAuthorizationServiceInterface;
use Segments\Nyo\Services\Registration\UserRegistrationServiceInterface;
use VK\Client\VKApiClient;
use VK\OAuth\VKOAuth;

class AuthorizationController extends AbstractMvcController
{
    /**
     * @param null $code
     * @param null $state
     * @return mixed
     * @throws \Exception
     */
    protected function vkAction($code = null, $state = null)
    {
        //создадим сервис авторизации
        /**
         * @var $vk_auth_service VkAuthorizationService
         */
        $vk_auth_service = Ioc::factoryWithVariadic(VkAuthorizationServiceInterface::class, Ioc::call(SessionInterface::class, 'getInstance'),
            new VKOAuth());

        //начальный этап - авторизация пользователя и получение code
        if (empty($state)) {
            return $this->redirectToUrl($vk_auth_service->getAuthorizationDialogUrl());
        }

        //была ли ошибка на каком то этапе авторизации
        $all_parameters = $this->route->getParameters();
        if (array_search('error', $all_parameters)) {
            throw new \Exception('Error during VK authorization!');
        }

        if ($state == 'authorized' && empty($code)) {
            throw new \Exception('Error during VK authorization! On "authorized" state!');
        }

        //теперь получим access_token и user_id
        /**
         *  array['access_token', 'user_id']
         * @var array $access_token_and_user_id_assoc_array
         */
        try {
            $access_token_and_user_id_assoc_array = $vk_auth_service->getAccessTokenAndUserId($code);
        } catch (ServiceException $e) {
            return $this->redirect('Authorization', 'vk');
        }


        //авторизуемся по user_id от VK.com
        /** @var AuthorizationServiceInterface $auth_service */
        $auth_service = Ioc::factory(AuthorizationServiceInterface::class);
        $auth_type = new AuthorizationTypeEnum(AuthorizationTypeEnum::EXTERNAL_VK);
        $user_authorized = $auth_service->authorizeByUserId($access_token_and_user_id_assoc_array['user_id'], $auth_type);

        //если это новый пользователь, то зарегистрируем его
        if (empty($user_authorized)) {
            /** @var UserRegistrationServiceInterface $registration_service */
            $registration_service = Ioc::factory(UserRegistrationServiceInterface::class);
            $registered_user = $registration_service
                                    ->registerAsVkUser(
                                        $access_token_and_user_id_assoc_array['user_id'],
                                        $access_token_and_user_id_assoc_array['access_token'],
                                        $vk_auth_service
                                    );

            //авторизуемся
            $auth_service->authorizeByUserId($registered_user->userId, $auth_type);
        }

        //редирект на главную
        return $this->redirect('Home', 'Index');
    }

}