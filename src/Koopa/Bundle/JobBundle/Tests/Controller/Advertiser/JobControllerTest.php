<?php

namespace Koopa\Bundle\JobBundle\Tests\Controller\Advertiser;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class JobControllerTest extends WebTestCase
{
    /**
     * @var Client
     */
    protected static $client;

    /**
     * @var UrlGeneratorInterface
     */
    protected static $router;

    protected static $userManager;

    protected static $entityManager;

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

    public function testNew()
    {
        self::$entityManager = self::$kernel->getContainer()->get('doctrine.orm.default_entity_manager');

        $sk = self::$entityManager->getRepository('KoopaJobBundle:Skill')->findAll();
        $lc = self::$entityManager->getRepository('KoopaJobBundle:Location')->findAll();
        $sc = self::$entityManager->getRepository('KoopaJobBundle:SubCategory')->findAll();

        $skills = [
            $sk[0]->getId(),
            $sk[count($sk) - 1]->getId(),
        ];
        $locations = [
            $lc[0]->getId(),
            $lc[count($sk) - 1]->getId(),
        ];
        $subCategories = [
            $sc[0]->getId(),
            $sc[count($sk) - 1]->getId(),
        ];

        $url     = self::$router->generate('advertiser_jobs_new');
        $crawler = self::$client->request('GET', $url);

        $form = $crawler->filter('form#form-job')->form(
            [
                'job_job[title]'         => 'test of job title',
                'job_job[summary]'       => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur, rerum?',
                // 'job_job[timeLeft]'      => (new \Datetime())->format(\DateTime::RFC822),
                // 'job_job[startAt]'       => (new \Datetime())->format(\DateTime::RFC822),
                'job_job[paymentMethod]' => 'par mois',
                'job_job[skills]'        => $skills,
                'job_job[locations]'     => $locations,
                'job_job[subCategories]' => $subCategories,
            ],
            'POST'
        );

        self::$client->submit($form);

        $crawler = self::$client->followRedirect();
        $result = $crawler->filter('html:contains("test of job title")');

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $this->assertTrue($result->count() > 0);
    }

    public function testIndex()
    {
        $url     = self::$router->generate('advertiser_jobs_index');
        $crawler = self::$client->request('GET', $url);

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $this->assertTrue($crawler->filter('table.table')->count() > 0);
        $item = $crawler->filter('[data-jobs]')->eq(1);

        return $item->attr('data-slug');
    }

    /**
     * @depends testIndex
     * @param string $slug
     * @return string
     */
    public function testShow($slug)
    {
        $url = self::$router->generate('advertiser_jobs_show', ['slug' => $slug]);
        $crawler = self::$client->request('GET', $url);

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $item = $crawler->filter('[data-job]');
        $this->assertTrue($item->count() > 0);

        return (int) $item->attr('data-id');
    }

    /**
     * @param integer $id
     * @depends testShow
     * @return integer
     */
    public function testEdit($id)
    {
        $url = self::$router->generate('advertiser_jobs_edit', ['id' => $id]);
        $crawler = self::$client->request('GET', $url);

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());

        $form = $crawler->filter('form#form-job')->form([
            'job_job[title]'  => 'this is the new title',
            'job_job[summary]'=> 'new description for my jobs',
        ]);

        self::$client->submit($form);
        $crawler = self::$client->followRedirect();

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $this->assertTrue($crawler->filter('html:contains("this is the new title")')->count() > 0);

        return $id;
    }

    /**
     * @param $id
     * @depends testEdit
     */
    public function testDelete($id)
    {
        $url = self::$router->generate('advertiser_jobs_delete', ['id' => $id]);
        self::$client->request('DELETE', $url);

        $content = self::$client->getResponse()->getContent();
        $this->assertNotRegExp('/this is the new title/', $content);
    }
}
