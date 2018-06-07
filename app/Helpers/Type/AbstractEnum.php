<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 6/7/18
 * Time: 9:36 AM
 */

namespace App\Helpers\Type;


abstract class AbstractEnum
{
    protected $code;
    protected $message;

    public function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
    }
}