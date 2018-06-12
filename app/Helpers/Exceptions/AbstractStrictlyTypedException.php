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
    /** @var AbstractCause $cause */
    protected $cause;

    /**
     * Проверка, что переданная причина поддерживается
     * данным типом исключения
     *
     * @param AbstractCause $cause
     */
//    abstract protected function isValidCause(AbstractCause $cause);

    /**
     * StrictlyTypedException constructor.
     * @param AbstractCause $cause
     * @param null|Throwable $previous
     */
    public function __construct(AbstractCause $cause = null, Throwable $previous = null)
    {
        $this->cause = $cause;

        $message = $this->cause != null ? $cause->getValue() : null;
        $code = $this->cause != null ? $cause->getKey() : null;

        parent::__construct($message, $code, $previous);
    }

    /**
     * Возвращает причину исключения
     *
     * @return AbstractCause
     */
    public function getCause() : AbstractCause
    {
        return $this->cause;
    }
}