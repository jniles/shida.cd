<?php

namespace Koopa\Bundle\JobBundle\Tests\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SubCategoryControllerTest extends WebTestCase
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
        $url = self::$router->generate('manager_job_subcategories');
        $crawler = self::$client->request('GET', $url);

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $this->assertTrue($crawler->filter('table.table tr')->count() >= 2);
    }

    public function testNew()
    {
        $url = self::$router->generate('manager_job_subcategories_new');
        $crawler = self::$client->request('GET', $url);

        $form = $crawler->filter('form#form-job-subcategory')->form(
            [
                'job_subcategory[name]' => 'test of subcategory',
            ],
            'POST'
        );

        self::$client->submit($form);

        $crawler = self::$client->followRedirect();
        $result = $crawler->filter('table.table td:contains("test of subcategory")');

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $this->assertTrue($result->count() > 0);

        return (int) $result->parents()->attr('data-id');
    }


    /**
     * @depends testNew
     */
    public function testShow($id)
    {
        $url = self::$router->generate('manager_job_subcategories_show', ['id' => $id]);
        $crawler = self::$client->request('GET', $url);

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $this->assertTrue($crawler->filter('html:contains("test of subcategory")')->count() > 0);

        return $id;
    }

    /**
     * @depends testShow
     */
    public function testEdit($id)
    {
        $url     = self::$router->generate('manager_job_subcategories_edit', ['id' => $id]);
        $crawler = self::$client->request('GET', $url);

        $form = $crawler->filter('form#form-job-subcategory')->form(
            [
                'job_subcategory[name]' => 'update test of subcategory',
            ],
            'POST'
        );

        self::$client->submit($form);

        $crawler = self::$client->followRedirect();
        $result  = $crawler->filter('table.table td:contains("update test of subcategory")');

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $this->assertTrue($result->count() > 0);

        return $id;
    }

    /**
     * @depends testEdit
     */
    public function testDelete($id)
    {
        $url     = self::$router->generate('manager_job_subcategories_edit', ['id' => $id]);
        $crawler = self::$client->request('GET', $url);

        $form = $crawler->filter('form#form-job-subcategory-delete')->form();

        self::$client->submit($form);

        $crawler = self::$client->followRedirect();
        $result  = $crawler->filter('table.table td:contains("update test of subcategory")');

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $this->assertTrue($result->count() == 0);
    }
}
