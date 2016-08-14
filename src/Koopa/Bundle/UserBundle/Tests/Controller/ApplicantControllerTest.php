<?php

namespace Koopa\Bundle\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ApplicantControllerTest extends WebTestCase
{
    /**
     * @var [type]
     */
    protected static $client;

    /**
     * @var [type]
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
                'PHP_AUTH_USER' => 'jean',
                'PHP_AUTH_PW'   => '0000',
            ]
        );

        self::$router = static::$kernel->getContainer()->get('router');
    }

    public function testIndex()
    {
        $url     = self::$router->generate('applicants_index');
        $crawler = self::$client->request('GET', $url);

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $this->assertTrue($crawler->filter('html:contains("jean")')->count() > 0);
    }
}
