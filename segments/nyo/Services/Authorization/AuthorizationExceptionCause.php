<?php
/**
 * Причина возникновения исключений при
 * авторизации пользователей в системе
 *
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 6/7/18
 * Time: 11:01 AM
 */

namespace Segments\Nyo\Services\Authorization;


use App\Helpers\Exceptions\ExceptionCause;

class AuthorizationExceptionCause extends ExceptionCause
{
    const NOT_REGISTERED = 'User is not registered!';
    const ALREADY_AUTHORIZED = 'User already authorized!';
}