<?php

namespace Koopa\Bundle\JobBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Koopa\Bundle\JobBundle\Entity\Job;
use FOS\UserBundle\Doctrine\UserManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadJobData implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var FOS\UserBundle\Doctrine\UserManager
     */
    protected $userManger;

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $entityManger;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container    = $container;
        $this->entityManger = $this->container->get('doctrine.orm.entity_manager');
        $this->userManger   = $this->container->get('fos_user.user_manager');
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        // $this->setServices();

        $jobs = $this->jobProvider();

        foreach ($jobs as $job) {
            $manager->persist($job);
        }

        $manager->flush();
    }

    /**
     * get the first ans last value of array
     *
     * @param  array  $collections
     * @return mixed
     */
    public function getFirstLast(array $collections)
    {
        return [$collections[0], $collections[count($collections) - 1]];
    }

    /**
     * job provider
     *
     * @return array
     */
    public function jobProvider()
    {
        $user          = $this->userManger->findUserByUsername('jose');
        $skills        = $this->entityManger->getRepository('KoopaJobBundle:Skill')->findAll();
        $locations     = $this->entityManger->getRepository('KoopaJobBundle:Location')->findAll();
        $SubCategories = $this->entityManger->getRepository('KoopaJobBundle:SubCategory')->findAll();

        $skills        = $this->getFirstLast($skills);
        $locations     = $this->getFirstLast($locations);
        $SubCategories = $this->getFirstLast($SubCategories);

        $data = [];
        for ($i = 1; $i <= 3; $i++) {
            $job = new Job();
            $job->setActive(true);
            $job->setTitle('offre numero ' . $i);
            $job->setSummary('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque iste reiciendis suscipit vitae cumque magni sunt, ut odit necessitatibus architecto numquam esse dolore facilis rem.');
            $job->setCreatedAt(new \DateTime());
            $job->setStartAt(new \DateTime());
            $job->setTimeLeft(new \DateTime());
            $job->setMode('full time');
            $job->setPaymentMethod('per month');
            $job->setSalary($i . '000');
            $job->setUser($user);

            foreach ($skills as $skill) {
                $job->addSkill($skill);
            }

            foreach ($locations as $location) {
                $job->addLocation($location);
            }

            foreach ($SubCategories as $SubCategory) {
                $job->addSubCategory($SubCategory);
            }

            $data[] = $job;
        }

        return $data;
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 5;
    }
}
