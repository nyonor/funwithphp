<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/4/18
 * Time: 7:24 PM
 */

namespace App\Modules\Mvc\Controller\ActionResult;


use Exception;

abstract class AbstractActionResult implements ActionResultInterface
{
    protected $isSuccessful = false;

    /**
     * @var $exception Exception
     */
    protected $exception;

    public function isSuccessful(): bool
    {
        return empty($this->exception);
    }
}