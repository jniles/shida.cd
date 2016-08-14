<?php

namespace Koopa\Bundle\JobBundle\Tests\Controller\Admin;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\Routing\Router;
use FOS\UserBundle\Doctrine\UserManager;
use Doctrine\ORM\EntityManager;

class JobControllerTest extends WebTestCase
{
    /**
     * @var Client
     */
    protected static $client;

    /**
     * @var Router
     */
    protected static $router;

    /**
     * @var UserManager
     */
    protected static $userManger;

    /**
     * @var EntityManager
     */
    protected static $entityManger;

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

        self::$router     = static::$kernel->getContainer()->get('router');
        self::$userManger = static::$kernel->getContainer()->get('fos_user.user_manager');
        self::$entityManger = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
    }

    public function testNew()
    {
        $user = self::$userManger->findUserByUsername('jose');
        $userId = $user->getId();

        $sk = self::$entityManger->getRepository('KoopaJobBundle:Skill')->findAll();
        $lc = self::$entityManger->getRepository('KoopaJobBundle:Location')->findAll();
        $sc = self::$entityManger->getRepository('KoopaJobBundle:SubCategory')->findAll();

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

        $url     = self::$router->generate('manager_job_jobs_new', ['id' => $userId]);
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
        $url = self::$router->generate('manager_job_jobs');
        $crawler = self::$client->request('GET', $url);

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $this->assertTrue($crawler->filter('html:contains("lists")')->count() > 0);

        $tr = $crawler->filter('table.table tbody tr')->eq(0);
        return (int) $tr->attr('data-id');
    }

    /**
     * @depends testIndex
     * @param string $id
     */
    public function testShow($id)
    {
        $url = self::$router->generate('manager_job_jobs_show', ['id' => $id]);
        self::$client->request('GET', $url);

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
    }
}
