<?php

namespace Koopa\Bundle\JobBundle\Tests\Controller\Immoffreur;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DashboardControllerTest extends WebTestCase
{
    /**
     * @var Client
     */
    protected static $client;

    /**
     * @var UrlGeneratorInterface
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
                'PHP_AUTH_USER' => 'dieu',
                'PHP_AUTH_PW'   => '0000',
            ]
        );

        self::$router = static::$kernel->getContainer()->get('router');
    }

    public function testIndex()
    {
        $url = self::$router->generate('immoffreur_home');
        $crawler = self::$client->request('GET', $url);

        $this->assertEquals(200, self::$client->getResponse()->getStatusCode());
    }
}
