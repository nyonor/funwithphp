<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/8/18
 * Time: 11:07 AM
 */

namespace App\Pipeline;


use App\Http\ResponseInterface;

interface ResponseHandlerInterface
{
    public function handle(ResponseInterface $response);
}