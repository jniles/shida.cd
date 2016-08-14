<?php

namespace Koopa\Bundle\JobBundle\Tests\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SkillControllerTest extends WebTestCase
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
                'PHP_AUTH_USER' => 'mano',
                'PHP_AUTH_PW'   => '0000',
            ]
        );
        self::$router = static::$kernel->getContainer()->get('router');
    }

    public function testIndex()
    {
        $url = self::$router->generate('manager_job_skills');
        $crawler = self::$client->request('GET', $url);

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $this->assertTrue($crawler->filter('table tr')->count() >= 2);
    }

    public function testNew()
    {
        $url = self::$router->generate('manager_job_skills_new');
        $crawler = self::$client->request('GET', $url);

        $form = $crawler->filter('form#form-job-skill')->form(
            [
                'job_skill[name]' => 'Skill of the test'
            ],
            'POST'
        );

        self::$client->submit($form);

        $crawler = self::$client->followRedirect();
        $result = $crawler->filter('table.table td:contains("Skill of the test")');

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $this->assertTrue($result->count() > 0);

        return (int) $result->parents()->attr('data-id');
    }

    /**
     * @depends testNew
     */
    public function testShow($id)
    {
        $url     = self::$router->generate('manager_job_skills_show', ['id' => $id]);
        $crawler = self::$client->request('GET', $url);

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $this->assertTrue($crawler->filter('html:contains("Skill of the test")')->count() > 0);

        return $id;
    }

    /**
     * @depends testShow
     */
    public function testEdit($id)
    {
        $url     = self::$router->generate('manager_job_skills_edit', ['id' => $id]);
        $crawler = self::$client->request('GET', $url);

        $form = $crawler->filter('form#form-job-skill')->form(
            [
                'job_skill[name]' => 'Skill of the test updated'
            ],
            'POST'
        );

        self::$client->submit($form);

        $crawler = self::$client->followRedirect();
        $result  = $crawler->filter('table.table td:contains("Skill of the test updated")');

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $this->assertTrue($result->count() > 0);

        return $id;
    }

    /**
     * @depends testEdit
     */
    public function testDelete($id)
    {
        $url     = self::$router->generate('manager_job_skills_edit', ['id' => $id]);
        $crawler = self::$client->request('GET', $url);

        $form = $crawler->filter('form#form-job-skill-delete')->form();

        self::$client->submit($form);

        $crawler = self::$client->followRedirect();
        $result  = $crawler->filter('table.table td:contains("Skill of the test updated")');

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $this->assertTrue($result->count() == 0);
    }
}
