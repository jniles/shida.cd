<?php

namespace Koopa\Bundle\JobBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionControllerTest extends WebTestCase
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
     *
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

    public function testNew()
    {
        $url = self::$router->generate('jobs_index');
        $crawler = self::$client->request('GET', $url);
        $item = $crawler->filter('[data-jobs]')->eq(0);

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $this->assertTrue($item->count() > 0);

        $slug = $item->attr('data-slug');
        $url = self::$router->generate('jobs_show', ['slug' => $slug]);
        $crawler = self::$client->request('GET', $url);

        $item = $crawler->filter('[data-job]')->eq(0);

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $this->assertTrue($item->count() > 0);
        $id = $item->attr('data-id');

        $url     = self::$router->generate('job_subscriptions_subscribe', ['id' => $id]);
        $crawler = self::$client->request('GET', $url);

        $form = $crawler->filter('form#form-job-subscription')->form();

        self::$client->submit($form);

        $crawler = self::$client->followRedirect();

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $this->assertTrue($crawler->filter('h2')->count() > 0);
    }
}
