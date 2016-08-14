<?php

namespace Koopa\Bundle\AppBundle\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PageControllerTest extends WebTestCase
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
        self::$client = static::createClient();
        self::$router = static::$kernel->getContainer()->get('router');
    }

    public function testIndex()
    {
        $url     = self::$router->generate('pages_index');
        $crawler = self::$client->request('GET', $url);

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $this->assertTrue($crawler->filter('h2')->count() > 0);
    }

    public function testEmployer()
    {
        $url     = self::$router->generate('pages_employer');
        $crawler = self::$client->request('GET', $url);

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $this->assertTrue($crawler->filter('h1')->count() > 0);
    }

    // public function testApplicant()
    // {
    //     $url     = self::$router->generate('pages_applicant');
    //     $crawler = self::$client->request('GET', $url);

    //     $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
    //     $this->assertTrue($crawler->filter('h1')->count() > 0);
    // }
}
