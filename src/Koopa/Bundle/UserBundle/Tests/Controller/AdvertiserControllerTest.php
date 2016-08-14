<?php

namespace Koopa\Bundle\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AdvertiserControllerTest extends WebTestCase
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
                'PHP_AUTH_USER' => 'jose',
                'PHP_AUTH_PW'   => '0000',
            ]
        );

        self::$router = static::$kernel->getContainer()->get('router');
    }

    public function testIndex()
    {
        $url     = self::$router->generate('advertisers_index');
        $crawler = self::$client->request('GET', $url);

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $this->assertTrue($crawler->filter('h2')->count() > 0);
    }

    public function testShowUserProfile()
    {
        $url     = self::$router->generate('advertiser_jobs_index');
        $crawler = self::$client->request('GET', $url);

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $this->assertTrue($crawler->filter('h2')->count() > 0);

        $item = $crawler->filter('table [data-jobs]')->eq(2);
        $slug = $item->attr('data-slug');
        $url = self::$router->generate('advertiser_jobs_show', ['slug' => $slug]);
        $crawler = self::$client->request('GET', $url);


        $item = $crawler->filter('table [data-applicants]')->first();
        $id = $item->attr('data-id');
        $url = self::$router->generate('advertiser_users_show', ['username' => 'jean', 'subscription_id' => $id]);
        $crawler = self::$client->request('GET', $url);

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $this->assertTrue($crawler->filter('table.table')->count() > 0);
    }
}
