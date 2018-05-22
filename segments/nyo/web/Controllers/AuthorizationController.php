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
use Segments\Nyo\Model\Services\Authorization\Vk\VkAuthorizationServiceInterface;
use Segments\Nyo\Model\Services\Authorization\Vk\VkAuthorizationService;

class AuthorizationController extends AbstractMvcController
{
    protected function vkAction($state = null)
    {
        /**
         * @var $vk_auth_service VkAuthorizationService
         */
        $vk_auth_service = Ioc::factory(VkAuthorizationServiceInterface::class);
        return $this->redirect('Home','index');
    }

}