<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/28/18
 * Time: 7:43 PM
 */

namespace Segments\Nyo\Services\Registration;


use Segments\Nyo\Model\User\UserModel;
use Segments\Nyo\Services\Authorization\Vk\VkAuthorizationServiceInterface;

interface UserRegistrationServiceInterface
{
    public function registerAsVkUser($vk_client_id, $access_token, VkAuthorizationServiceInterface $vk_auth_service) : UserModel;
}