<?php
/**
 * Исключения, возникающие при авторизации
 * пользователей в системе
 *
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 6/6/18
 * Time: 8:27 PM
 */

namespace Segments\Nyo\Services\Authorization;


use App\Helpers\Exceptions\AbstractStrictlyTypedException;
use Throwable;

class AuthorizationException extends AbstractStrictlyTypedException
{
    protected $currentCause;

    public function __construct(AuthorizationExceptionCause $cause, Throwable $previous = null)
    {
        parent::__construct($cause, $previous);

        $this->currentCause = $cause;
    }
}