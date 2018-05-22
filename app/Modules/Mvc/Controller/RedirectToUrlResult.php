<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/22/18
 * Time: 7:57 PM
 */

namespace App\Modules\Mvc\Controller;


class RedirectToUrlResult extends AbstractActionResult implements RedirectToUrlResultInterface
{
    protected $url;

    public function __construct($url_to_redirect)
    {
        $this->url = $url_to_redirect;
    }

    public function getRenderedContent()
    {
        // TODO: Implement getRenderedContent() method.
    }

    public function getUrl()
    {
        return $this->url;
    }
}