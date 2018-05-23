<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/22/18
 * Time: 7:57 PM
 */

namespace App\Modules\Mvc\Controller\ActionResult;


use App\Modules\Mvc\Controller\ActionResult\AbstractActionResult;

class RedirectToUrlResult extends AbstractActionResult implements RedirectToUrlResultInterface
{
    protected $url;

    public function __construct($url_to_redirect)
    {
        $this->url = $url_to_redirect;
    }

    public function getResult()
    {
        return $this->url;
    }
}