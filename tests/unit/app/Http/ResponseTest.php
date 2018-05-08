<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/4/18
 * Time: 3:38 PM
 */

namespace App\Http;

use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{

    public function testWithStatus()
    {
        $response = new Response();
        $with_status = $response->withStatus(200);
        $this->assertEquals('OK', $with_status->getReasonPhrase());
        $this->assertEquals('200', $with_status->getStatusCode());

        $with_status = $response->withStatus(200, 'Alright!');
        $this->assertEquals('Alright!', $with_status->getReasonPhrase());
        $this->assertEquals('200', $with_status->getStatusCode());
    }

    public function testGetReasonPhrase()
    {
        $response = new Response();
        $response = $response->withStatus('404', 'Not Found');
        $this->assertEquals('Not Found', $response->getReasonPhrase());
    }
}
