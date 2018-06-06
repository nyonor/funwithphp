<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 6/6/18
 * Time: 8:37 PM
 */

namespace App\Helpers\Exceptions;


use Throwable;

class StrictlyTypedException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}