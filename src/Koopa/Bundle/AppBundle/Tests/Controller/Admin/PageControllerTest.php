<?php

namespace Koopa\Bundle\AppBundle\Tests\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

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
        self::$client = static::createClient(
            [],
            [
                'PHP_AUTH_USER' => 'admin',
                'PHP_AUTH_PW'   => '0000',
            ]
        );
        self::$router = static::$kernel->getContainer()->get('router');
    }

    public function testIndex()
    {
        $url     = self::$router->generate('admin_pages_index');
        $crawler = self::$client->request('GET', $url);

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $this->assertTrue($crawler->filter('html:contains("Salut")')->count() > 0);
    }
}
