<?php

use App\Http\Request;
use App\Http\Stream;
use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 4/26/18
 * Time: 12:09 PM
 */

class RequestTest extends TestCase
{
    public function testGetProtocolVersionMethod()
    {
        $server_global_stub = ['SERVER_PROTOCOL' => 'Http/1.1'];
        $request = $this->getMockBuilder(Request::class)
                        ->disableOriginalConstructor()
                        ->setMethods(['getServerGlobal'])
                        ->getMock();
        $request->method('getServerGlobal')
                ->willReturn($server_global_stub);

        $this->assertEquals('1.1', $request->getProtocolVersion());
    }

    public function testWithProtocolVersionMethod()
    {
        $request = $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->setMethods(['getServerGlobal'])
            ->getMock();
        $server_global_stub = ['SERVER_PROTOCOL' => 'Http/1.2'];
        $request->method('getServerGlobal')
            ->willReturn($server_global_stub);

        $this->assertEquals('1.2', $request->getProtocolVersion());

        $new_request = $request->withProtocolVersion('1.1');

        $this->assertEquals('1.1', $new_request->getProtocolVersion());
        $this->assertNotSame($request,$new_request);
    }

    public function testGetHeadersMethod()
    {
        $request = $this->getMockBuilder(Request::class)
                        ->disableOriginalConstructor()
                        ->setMethods(['getHeadersArray'])
                        ->getMock();
        $headers_stub = [
            'header1' => 'h1',
            'header2' => 'h2',
            'header3' => [
                'some_header_3_key' => 'sh3k',
                'some_header_4_key' => 'sh4k'
            ],
        ];
        $request->method('getHeadersArray')
                ->willReturn($headers_stub);

        $this->assertArraySubset($request->getHeaders(), $headers_stub);
    }

    public function testHasHeaderMethod()
    {
        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->setMethods(['getHeadersArray'])
            ->getMock();
        $headers_stub = [
            'header1' => 'h1',
            'header2' => 'h2',
            'header3' => [
                'some_header_3_key' => 'sh3k',
                'some_header_4_key' => 'sh4k'
            ],
        ];
        $request->method('getHeadersArray')
            ->willReturn($headers_stub);

        $this->assertTrue($request->hasHeader('header1'));
        $this->assertTrue($request->hasHeader('HEADER2'));
        $this->assertTrue($request->hasHeader('header3'));
        $this->assertFalse($request->hasHeader('header5'));
        $this->assertFalse($request->hasHeader(null));
    }

    public function testGetHeaderMethod()
    {
        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->setMethods(['getHeadersArray'])
            ->getMock();
        $headers_stub = [
            'header1' => 'h1',
            'header2' => 'h2',
            'header3' => [
                'h31', 'h32', 'h33'
            ]
        ];
        $request->method('getHeadersArray')
            ->willReturn($headers_stub);

        $this->assertArraySubset(['h31'], $request->getHeader('heAder3'));
        $this->assertEquals(0, count($request->getHeader('not_existing_header')));
    }

    public function testGetHeaderLineMethod()
    {
        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->setMethods(['getHeadersArray'])
            ->getMock();
        $headers_stub = [
            'header1' => 'h1',
            'header2' => 'h2',
            'header3' => [
                'h31', 'h32', 'h33'
            ]
        ];
        $request->method('getHeadersArray')
            ->willReturn($headers_stub);

        $this->assertEquals('h1', $request->getHeaderLine('header1'));
        $this->assertEquals('', $request->getHeaderLine('not_existing_header'));
        $this->assertEquals('h31,h32,h33', $request->getHeaderLine('headeR3'));
    }

    public function testWithHeaderMethod()
    {
        $headers_stub = [
            'header1' => 'h1',
            'header2' => 'h2',
            'header3' => [
                'h31', 'h32', 'h33'
            ]
        ];

        $request = new Request([
            Request::HEADERS => $headers_stub,
            Request::PROTOCOL_VERSION => '1.1',
            Request::METHOD => 'POST'
        ], new Stream("some string"));

        $new_request = $request->withHeader('header1', 'h1n');

        $this->assertNotNull($new_request);
        $this->assertNotSame($new_request, $request);
        $this->assertEquals('h1n', $new_request->getHeaderLine('header1'));
        $this->assertEquals('h1n', $new_request->getHeaderLine('HEADER1'));
    }

    public function testWithAddedHeaderMethod()
    {
        $headers_stub = [
            'header1' => 'h1',
            'header2' => 'h2',
            'header3' => [
                'h31', 'h32', 'h33'
            ]
        ];

        $request = new Request([
            Request::HEADERS => $headers_stub,
            Request::PROTOCOL_VERSION => '1.1',
            Request::METHOD => 'POST'
        ], new Stream("some string"));

        $this->assertEquals($request->getHeader('header1')[0], 'h1');

        $new_request = $request->withAddedHeader('header1', ' added value');

        $this->assertNotSame($request, $new_request);
        $this->assertEquals($new_request->getHeader('header1')[0], 'h1 added value');
    }

    public function testWithoutHeaderMethod()
    {
        $headers_stub = [
            'header1' => 'h1',
            'header2' => 'h2',
            'header3' => [
                'h31', 'h32', 'h33'
            ]
        ];

        $request = new Request([
            Request::HEADERS => $headers_stub,
            Request::PROTOCOL_VERSION => '1.1',
            Request::METHOD => 'POST'
        ], new Stream("some string"));

        $new_req = $request->withoutHeader('header1');
        $this->assertEquals(0, count($new_req->getHeader('HeadeR1')));
        $this->assertEquals(0, count($new_req->getHeader('header1')));

        $new_req = $new_req->withoutHeader('HEADER2');
        $this->assertEquals(0, count($new_req->getHeader('HeadeR2')));
        $this->assertEquals(0, count($new_req->getHeader('header2')));

        $this->assertNotSame($request, $new_req);
    }


}