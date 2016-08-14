<?php

namespace Koopa\Bundle\JobBundle\Tests\Controller\Advertiser;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ParcelControllerTest extends WebTestCase
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
                'PHP_AUTH_USER' => 'dieu',
                'PHP_AUTH_PW'   => '0000',
            ]
        );

        self::$router = static::$kernel->getContainer()->get('router');
    }

    public function testNew()
    {
        // self::$entityManager = self::$kernel->getContainer()->get('doctrine.orm.default_entity_manager');

        $url     = self::$router->generate('immoffreur_parcels_new');
        $crawler = self::$client->request('GET', $url);

        $this->assertEquals(200, self::$client->getResponse()->getStatusCode());

        $form = $crawler->filter('form#form-parcel')->form(
            [
                'parcel[houseNumber]' => '3',
                'parcel[description]' => 'hello maison description',
                'parcel[address][city]' => 'Kinshasa',
                'parcel[address][street]' => 'foo street',
                'parcel[address][commune]' => 'bar commmune',
                'parcel[address][quarter]' => 'Q42',
                'parcel[address][city]' => 'Kinshasa',
            ]
        );

        self::$client->submit($form);

        $this->assertEquals(302, self::$client->getResponse()->getStatusCode());

        $crawler = self::$client->followRedirect();
        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
    }

    public function testIndex()
    {
        $url     = self::$router->generate('immoffreur_parcels_index');
        $crawler = self::$client->request('GET', $url);

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $this->assertTrue($crawler->filter('table.table')->count() > 0);
        $item = $crawler->filter('[data-parcel]')->eq(0);

        return $item->attr('data-id');
    }

    /**
     * @depends testIndex
     * @param integer $id
     * @return string
     */
    public function testShow($id)
    {
        $url = self::$router->generate('immoffreur_parcels_show', ['id' => $id]);
        $crawler = self::$client->request('GET', $url);

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $item = $crawler->filter('[data-parcel]');
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
        $url = self::$router->generate('immoffreur_parcels_edit', ['id' => $id]);
        $crawler = self::$client->request('GET', $url);

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());

        $form = $crawler->filter('form#form-job')->form([
            'parcel[description]'  => 'super foo description',
        ]);

        self::$client->submit($form);
        $crawler = self::$client->followRedirect();

        $this->assertEquals(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());
        $this->assertTrue($crawler->filter('html:contains("super foo description")')->count() > 0);

        return $id;
    }

    /**
     * @param $id
     * @depends testEdit
     */
    public function testDelete($id)
    {
        $url = self::$router->generate('immoffreur_parcels_delete', ['id' => $id]);
        self::$client->request('DELETE', $url);

        $content = self::$client->getResponse()->getContent();
        $this->assertNotRegExp('/super foo description/', $content);
    }
}
