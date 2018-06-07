<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 6/7/18
 * Time: 12:16 PM
 */

namespace Segments\Nyo\Services\Registration;


use App\Helpers\Exceptions\AbstractCause;
use App\Helpers\Exceptions\AbstractStrictlyTypedException;
use Throwable;

class UserRegistrationException extends AbstractStrictlyTypedException
{
    /**
     * UserRegistrationException constructor.
     * @param UserRegistrationExceptionCause $cause
     * @param Throwable|null $previous
     */
    public function __construct(UserRegistrationExceptionCause $cause, Throwable $previous = null)
    {
        /** @var TYPE_NAME $cause */
        parent::__construct($cause, $previous);
    }
}