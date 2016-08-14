<?php

namespace Koopa\Bundle\JobBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class JobControllerTest extends WebTestCase
{
    /**
     * @var Symfony\Bundle\FrameworkBundle\Client
     */
    protected static $client;

    /**
     * @var Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    protected static $router;

    public static function setUpBeforeClass()
    {
        self::$client = static::createClient([], []);
        self::$router = static::$kernel->getContainer()->get('router');
    }

    public function testIndex()
    {
        $url = self::$router->generate('jobs_index');
        $crawler = self::$client->request('GET', $url);
        $row = $crawler->filter('[data-jobs]')->eq(0);

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $this->assertTrue($row->count() > 0);

        return $row->attr('data-slug');
    }

    /**
     * @depends testIndex
     * @param string $slug
     */
    public function testShow($slug)
    {
        $url = self::$router->generate('jobs_show', ['slug' => $slug]);
        $crawler = self::$client->request('GET', $url);

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $this->assertTrue($crawler->filter('[data-job]')->count() > 0);
    }
}
