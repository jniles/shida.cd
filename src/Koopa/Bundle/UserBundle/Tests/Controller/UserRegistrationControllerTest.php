<?php

namespace Koopa\Bundle\UserBundle\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserRegistrationControllerTest extends WebTestCase
{
    protected static $client;

    public static function setUpBeforeClass()
    {
        self::$client = static::createClient();
    }

    public function url($url)
    {
        return static::$kernel->getContainer()->get('router')->generate($url);
    }

    public function testJoinUs()
    {
        $url = $this->url('users_join_us');
        $crawler = self::$client->request('GET', $url);

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
    }
}
