<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/4/18
 * Time: 11:04 AM
 */

namespace App\Http;

use PHPUnit\Framework\TestCase;

class UriTest extends TestCase
{

    public function testWithScheme()
    {
        $uri = new Uri();
        $uri_with_scheme = $uri->withScheme('http');
        $this->assertNotSame($uri, $uri_with_scheme);
    }

    public function test__toString()
    {
        $uri = new Uri();
        $uri_with_scheme = $uri->withScheme('http');
        $this->assertEquals('http:', (string)$uri_with_scheme);
    }

    public function testWithUserInfo()
    {
        $uri = new Uri();
        $uri_with_uinfo = $uri->withUserInfo('user', 'password');
        $this->assertEquals('user:password', $uri_with_uinfo->getUserInfo());

        $uri_with_uinfo_another = $uri_with_uinfo->withUserInfo('user2');
        $this->assertEquals('user2', $uri_with_uinfo_another->getUserInfo());
    }

    public function testWithQuery()
    {
        $uri = new Uri();
        $uri_with_q = $uri->withQuery('param1=val1&param2=val2');
        $this->assertEquals('param1=val1&param2=val2', $uri_with_q->getQuery());
    }

    public function testWithHost()
    {
        $uri = new Uri();
        $uri_with_host = $uri->withHost('somehost');
        $this->assertEquals('somehost', $uri_with_host->getHost());

        $another = $uri_with_host->withHost('somehostwithoutport');
        $this->assertEquals('somehostwithoutport', $another->getHost());
    }

    public function testGetPort()
    {
        $uri = new Uri();
        $uri_with_host = $uri->withHost('somehost');
        $this->assertEquals('somehost', $uri_with_host->getHost());

        $uri_with_port = $uri_with_host->withPort('8080');
        $this->assertEquals('8080', $uri_with_port->getPort());
        $this->assertEquals('somehost', $uri_with_port->getHost());
    }

    public function testGetPath()
    {
        $uri = new Uri();
        $with_path = $uri->withPath('/somePath/andSomeUriParam=1');
        $this->assertEquals(urlencode('/somePath/andSomeUriParam=1'), $with_path->getPath());

        $with_path = $with_path->withPath('someControllerMaybe');
        $this->assertEquals(urlencode('someControllerMaybe'), $with_path->getPath());

        $with_path = $with_path->withPath('');
        $this->assertEquals(urlencode(''), $with_path->getPath());

        $with_path = $with_path->withPath(urlencode('somecontroller/andaction/andsomeval=&1&2'));
        $this->assertEquals(urlencode('somecontroller/andaction/andsomeval=&1&2'), $with_path->getPath());
    }

    public function testGetAuthority()
    {
        $uri = new Uri();
        $uri = $uri
                ->withScheme('https')
                ->withHost('google.com')
                ->withUserInfo('userName', 'pass')
                ->withPort('80');

        $this->assertEquals('userName:pass@google.com:80', $uri->getAuthority());
    }

    public function testWithFragment()
    {
        $uri = new Uri();
        $with_fragment = $uri->withFragment('someFragment=?1');
        $this->assertEquals('someFragment=?1', $with_fragment->getFragment());
    }
}
