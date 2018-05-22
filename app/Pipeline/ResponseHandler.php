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
        $start_line = "HTTP" . "/" . $response->getProtocolVersion() . " " . $response->getStatusCode()
            . " " . $response->getReasonPhrase();

        header($start_line, true, $response->getStatusCode());

        foreach ($response->getHeaders() as $header_name => $header_value)
        {
            header ($header_name . ':' . $header_value);
        }

        echo $response->getBody();
    }
}