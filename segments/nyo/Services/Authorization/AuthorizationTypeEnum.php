<?php
/**
 * Используеется для хранения типов авторизации
 *
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/24/18
 * Time: 6:18 PM
 */

namespace Segments\Nyo\Services\Authorization;


use MyCLabs\Enum\Enum;

class AuthorizationTypeEnum extends Enum
{
    // внутренняя авторизация, соотносится с таблице user
    public const INTERNAL = 'internal';

    // внешняя авторизация через VK API, соотносится с таблицей user_vk
    public const EXTERNAL_VK = 'vk';
}