<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/4/18
 * Time: 7:24 PM
 */

namespace App\Modules\Mvc\Controller\ActionResult;


use Exception;

abstract class AbstractActionResult
{
    protected $isSuccessful = true;

    /**
     * @var $exception Exception
     */
    protected $exception;

    public function isSuccessful(): bool
    {
        return empty($this->exception);
    }

    public function getException()
    {
        return $this->exception;
    }
}