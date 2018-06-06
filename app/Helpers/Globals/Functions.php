<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 6/6/18
 * Time: 11:43 AM
 */

namespace App\Helpers\Globals;

use App\Ioc\Ioc;
use App\Ioc\IocInterface;

/**
 * Возвращает IoC контейнер системы
 * @return IocInterface
 */
function container() : IocInterface
{
    /** @var IocInterface $container */
    $container = Ioc::getInstance();
    return $container;
}

/**
 * Возвращает инстанс сессии
 *
 * @return \App\Http\SessionInterface
 */
function session() : \App\Http\SessionInterface
{
    return container()->create(\App\Http\SessionInterface::class);
}