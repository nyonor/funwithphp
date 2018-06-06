<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 6/4/18
 * Time: 2:19 PM
 */

namespace App\Services;


use Exception;
use Throwable;

class ServiceException extends Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}