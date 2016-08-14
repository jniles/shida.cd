<?php

namespace Koopa\Bundle\JobBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Koopa\Bundle\JobBundle\Entity\Subscription;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadSubscriptionData implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    private $entityManager;

    private $userManager;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user = $this->userManager->findUserByUsername('jean');
        $jobs = $this->entityManager
            ->getRepository('KoopaJobBundle:Job')
            ->findAll();

        foreach ($jobs as $job) {
            $subscription = new Subscription();
            $subscription->setUser($user)->setJob($job);
            $this->entityManager->persist($subscription);
        }

        $this->entityManager->flush();
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container    = $container;
        $this->entityManager = $this->container->get('doctrine.orm.entity_manager');
        $this->userManager   = $this->container->get('fos_user.user_manager');
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 6;
    }
}
