<?php

namespace Asmaster\EquipTwig\Tests\Extension;

use Zend\Diactoros\Uri;
use Zend\Diactoros\Stream;
use Zend\Diactoros\ServerRequest;
use Asmaster\EquipTwig\Extension\RequestExtension;

class RequestExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testAddExtension()
    {
        if (!class_exists('\Twig_Environment')) {
            $this->markTestSkipped('Twig is not installed');
        }

        $request = $this->getMock(ServerRequest::class);
        $extenstion = new RequestExtension($request);

        $loader = $this->getMock('\Twig_LoaderInterface');

        $twig = new \Twig_Environment($loader);
        $twig->addExtension($extenstion);

        $this->assertArrayHasKey('request', $twig->getExtensions());
        $this->assertArrayHasKey('absolute_url', $twig->getFunctions());
        $this->assertArrayHasKey('relative_url', $twig->getFunctions());
    }

    /**
     * @dataProvider getGenerateAbsoluteUrlData()
     */
    public function testGenerateAbsoluteUrl($path, $url, $expected)
    {
        $request = $this->createRequest($url);

        $extension = new RequestExtension($request);
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

    /**
     * @dataProvider getGenerateRelativeUrlData()
     */
    public function testGenerateRelativeUrl($path, $url, $expected)
    {
        $request = $this->createRequest($url);

        $extension = new RequestExtension($request);
        $relativeUrl = $extension->generateRelativeUrl($path);

        $this->assertEquals($expected, $relativeUrl);
    }

    public function getGenerateRelativeUrlData()
    {
        return [
            ['/a/b/c/foo.png', 'http://localhost/a/b/c/d', 'foo.png'],
            ['/a/b/foo.png', 'http://localhost/a/b/c/d', '../foo.png'],
            ['/a/b/c/d', 'http://localhost/a/b/c/d', ''],
            ['/a/b/c/', 'http://localhost/a/b/c/d', './'],
            ['/a/b/c/other', 'http://localhost/a/b/c/d', 'other'],
            ['/a/b/z/foo.png', 'http://localhost/a/b/c/d', '../z/foo.png'],
            ['/a/b/c/this:that', 'http://localhost/a/b/c/d', './this:that'],
            ['/a/b/c/foo/this:that', 'http://localhost/a/b/c/d', 'foo/this:that'],
            ['/', 'http://localhost', '/'],
            ['//', 'http://localhost', '//']
        ];
    }

    /**
     * @param string $url
     *
     * @return ServerRequest $request
     */
    public function createRequest($url)
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

        return $request;
    }
}
