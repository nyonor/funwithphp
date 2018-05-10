<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/8/18
 * Time: 11:07 AM
 */

namespace App\Pipeline;


use App\Http\ResponseInterface;

class ResponseHandler implements ResponseHandlerInterface
{

    public function handle(ResponseInterface $response)
    {
        //headers
        foreach ($response->getHeaders() as $header_name => $header_value)
        {
            header($header_name . ':' . $header_value, true, $response->getStatusCode());
        }

        //body
        echo $response->getBody();
    }
}