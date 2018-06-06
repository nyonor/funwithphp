<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 6/6/18
 * Time: 8:27 PM
 */

namespace Segments\Nyo\Services\Authorization;


use App\Services\ServiceException;
use Throwable;

class AuthorizationException extends ServiceException
{
    const CAUSE_NOT_REGISTERED = 'User is not registered!';
    const CAUSE_ALREADY_AUTHORIZED = 'User already authorized!';

    protected $currentCause;

    public function __construct(string $cause, string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message ?? $cause, $code, $previous);

        $this->currentCause = $cause;
    }

    protected function getCause()
    {
        return $this->currentCause;
    }
}