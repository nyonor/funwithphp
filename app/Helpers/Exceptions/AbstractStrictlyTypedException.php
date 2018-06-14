<?php
/**
 * Строго типизированное исключение,
 * позволяет отслеживать причину исключения
 *
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 6/6/18
 * Time: 8:37 PM
 */

namespace App\Helpers\Exceptions;


use Exception;
use Throwable;

abstract class AbstractStrictlyTypedException extends Exception
{
    /** @var ExceptionCause $cause */
    protected $cause;

    /**
     * Проверка, что переданная причина поддерживается
     * данным типом исключения
     *
     * @param ExceptionCause $cause
     */
//    abstract protected function isValidCause(AbstractCause $cause);

    /**
     * StrictlyTypedException constructor.
     * @param ExceptionCause $cause
     * @param null|Throwable $previous
     */
    public function __construct(ExceptionCause $cause = null, Throwable $previous = null)
    {
        $this->cause = $cause;

        $message = $this->cause != null ? $cause->getValue() : null;
        $code = $this->cause != null ? $cause->getKey() : null;

        parent::__construct($message, null, $previous);
    }

    /**
     * Возвращает причину исключения
     *
     * @return ExceptionCause
     */
    public function getCause() : ExceptionCause
    {
        return $this->cause;
    }
}