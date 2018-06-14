<?php
/**
 * Причины исключения при регистрации пользователей
 *
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 6/7/18
 * Time: 12:17 PM
 */

namespace Segments\Nyo\Services\Registration;


use App\Helpers\Exceptions\ExceptionCause;

class UserRegistrationExceptionCause extends ExceptionCause
{
    public const ALREADY_REGISTRED = 'VK user with provided id is already registered!';
    public const DATA_IS_NOT_VALID = 'Vk data for registration is not valid!';
}