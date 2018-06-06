<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/22/18
 * Time: 7:43 PM
 */

namespace Segments\Nyo\Services\Authorization\Vk;


interface VkAuthorizationServiceInterface
{
    /**
     * Проверить соответствует ли переданный access_token
     * vk_user_id. access_token должен быть действующим иначе будет возвращен false
     *
     * @param $vk_user_id
     * @param $access_token
     * @return mixed
     */
    public function checkIsValid($vk_user_id, $access_token);
}