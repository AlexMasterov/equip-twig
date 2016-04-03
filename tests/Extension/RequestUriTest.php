<?php

namespace Asmaster\EquipTwigtests;

use Zend\Diactoros\Uri;
use Zend\Diactoros\Stream;
use Zend\Diactoros\ServerRequest;
use Asmaster\EquipTwig\Extension\RequestUri;

class RequestUriTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getGenerateAbsoluteUrlData()
     */
    public function testGenerateAbsoluteUrl($path, $url, $expected)
    {
        $uri = new Uri($url);
        $request = new ServerRequest(
            $server  = [],
            $files   = [],
            $uri     = $uri,
            $method  = 'GET',
            $body    = 'php://input',
            $headers = []
        );

        $extension = new RequestUri($request);
        $absoluteUrl = $extension->generateAbsoluteUrl($path);

        $this->assertEquals($expected, $absoluteUrl);
    }

    public function getGenerateAbsoluteUrlData()
    {
        return [
            ['/foo.png', '', '/foo.png'],
            ['/foo.png', 'http://localhost/foo', 'http://localhost/foo.png'],
            ['foo.png', 'http://localhost/foo', 'http://localhost/foo/foo.png'],
            ['foo.png', 'http://localhost/bar', 'http://localhost/bar/foo.png'],
            ['foo.png', 'http://localhost/foo/bar/', 'http://localhost/foo/bar/foo.png'],
            ['/foo.png', 'http://localhost:80', 'http://localhost/foo.png'],
            ['/foo.png', 'http://localhost:8080', 'http://localhost:8080/foo.png'],
            ['/foo.png', 'https://localhost:443', 'https://localhost/foo.png'],
            ['/', 'http://localhost', 'http://localhost/'],
            ['//', 'http://localhost', '//']
        ];
    }

    public function testValidExtensionName()
    {
        $validName = 'requestUri';

        $request = $this->getMock(ServerRequest::class);
        
        $extension = new RequestUri($request);
        $extensionName = $extension->getName();

        $this->assertEquals($validName, $extensionName);
    }
}
