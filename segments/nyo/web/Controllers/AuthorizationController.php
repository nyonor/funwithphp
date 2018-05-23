<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/21/18
 * Time: 3:58 PM
 */

namespace Segments\Nyo\Web\Controllers;


use App\Ioc\Ioc;
use App\Modules\Mvc\Controller\AbstractMvcController;
use Segments\Nyo\Model\Services\Authorization\Vk\VkAuthorizationService;
use Segments\Nyo\Model\Services\Authorization\Vk\VkAuthorizationServiceInterface;

class AuthorizationController extends AbstractMvcController
{
    protected function vkAction($code = null, $state = null)
    {
        /**
         * @var $vk_auth_service VkAuthorizationService
         */
        $vk_auth_service = Ioc::factory(VkAuthorizationServiceInterface::class);

        //начальный этап - авторизация пользователя и получение code
        if (empty($state)) {
            return $this->redirectToUrl($vk_auth_service->getAuthorizationDialogUrl());
        }

        if ($state == 'authorized') {

        }
    }

}