<?php

namespace Koopa\Bundle\JobBundle\Tests\Controller\Advertiser;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionControllerTest extends WebTestCase
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

    public function testAcceptUser()
    {
        // GET: on the page index jobs published
        $url = self::$router->generate('advertiser_jobs_index');
        $crawler = self::$client->request('GET', $url);

        // assert the response
        $this->assertEquals(200, self::$client->getResponse()->getStatusCode());
        $item = $crawler->filter('[data-jobs]')->eq(2);
        $this->assertTrue($item->count() > 0);

        // GET: on the page show a specific job
        $url = self::$router->generate('advertiser_jobs_show', ['slug' => $item->attr('data-slug')]);
        $crawler = self::$client->request('GET', $url);


        // assert the response and click on the fist link
        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $linkUser = $crawler->filter('[data-applicants] a')->eq(0);
        $crawler = self::$client->click($linkUser->link());

        // assert the response and click on the accept action
        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $linkAccept = $crawler->filter('[data-accept]');
        self::$client->click($linkAccept->link());

        $this->assertEquals(Response::HTTP_FOUND, self::$client->getResponse()->getStatusCode());
    }


    public function testDeclineUser()
    {
        // GET: on the page index jobs published
        $url = self::$router->generate('advertiser_jobs_index');
        $crawler = self::$client->request('GET', $url);

        // assert the response
        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $item = $crawler->filter('[data-jobs]')->eq(2);
        $this->assertTrue($item->count() > 0);

        // GET: on the page show a specific job
        $url = self::$router->generate('advertiser_jobs_show', ['slug' => $item->attr('data-slug')]);
        $crawler = self::$client->request('GET', $url);


        // assert the response and click on the fist link
        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $linkUser = $crawler->filter('[data-applicants] a')->eq(0);
        $crawler = self::$client->click($linkUser->link());

        // assert the response and click on the decline action
        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $linkAccept = $crawler->filter('[data-accept]');
        self::$client->click($linkAccept->link());

        $this->assertEquals(Response::HTTP_FOUND, self::$client->getResponse()->getStatusCode());
    }
}
