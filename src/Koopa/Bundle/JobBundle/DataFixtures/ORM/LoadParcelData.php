<?php

namespace Koopa\Bundle\JobBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Koopa\Bundle\JobBundle\Entity\Parcel;
use Koopa\Bundle\JobBundle\Entity\House;
use Koopa\Bundle\JobBundle\Entity\Address;
use FOS\UserBundle\Doctrine\UserManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadParcelData implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var FOS\UserBundle\Doctrine\UserManager
     */
    protected $userManager;

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container    = $container;
        $this->entityManager = $this->container->get('doctrine.orm.entity_manager');
        $this->userManager   = $this->container->get('fos_user.user_manager');
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $user = $this->userManager->findUserByUsername('dieu');
        $address = new Address();
        $address
            ->setCity('Kinshasa')
            ->setStreet('ngele')
            ->setCommune('Lingwala')
            ->setQuarter('Pakadjuma')
        ;

        $house = new House();
        $house
            ->setHasStore(true)
            ->setHasKitchen(true)
            ->setRooms(3)
            ->setPrice(300)
            ->setForSale(false)
            ->setDescription('ceci est la description de ma maison')
        ;

        $parcel = new Parcel();
        $parcel
            ->setHouseNumber(5)
            ->setDescription('ceci est une description creer par Dieu')
            ->setAddress($address)
            ->addHouse($house)
            ->setAuthor($user)
        ;

        $manager->persist($parcel);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 7;
    }
}
