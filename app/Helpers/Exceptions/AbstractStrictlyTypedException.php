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
    public function __construct(AbstractCause $cause, Throwable $previous = null)
    {
        $this->cause = $cause;
        parent::__construct($this->cause->getValue(), $this->cause->getKey(), $previous);
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