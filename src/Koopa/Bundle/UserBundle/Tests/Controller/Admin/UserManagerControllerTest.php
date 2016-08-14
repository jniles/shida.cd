<?php

namespace Koopa\Bundle\UserBundle\Tests\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserManagerControllerTest extends WebTestCase
{
    /**
     * @var Symfony\Bundle\FrameworkBundle\Client
     */
    protected static $client;

    /**
     * @var Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    protected static $router;

    /**
     * setUpBeforeClass
     */
    public static function setUpBeforeClass()
    {
        self::$client = static::createClient(
            [],
            [
                'PHP_AUTH_USER' => 'mano',
                'PHP_AUTH_PW'   => '0000',
            ]
        );

        self::$router = static::$kernel->getContainer()->get('router');
    }

    public function testIndex()
    {
        $url     = self::$router->generate('admin_usermanagers');
        $crawler = self::$client->request('GET', $url);

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $this->assertTrue($crawler->filter('html:contains("lists of users")')->count() > 0);

        return (int) $crawler->filter('table.table tbody tr')->eq(0)->attr('data-id');
    }

    /**
     * @depends testIndex
     */
    public function testShow($id)
    {
        $url     = self::$router->generate('admin_usermanagers_show', ['id' => $id]);
        $crawler = self::$client->request('GET', $url);

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        // $this->assertTrue($crawler->filter('html:contains("lists of users")')->count() > 0);
    }

    public function testList()
    {
        $url = self::$router->generate('admin_usermanagers_list', ['role' => 'advertiser']);
        $crawler = self::$client->request('GET', $url);

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
    }
}
