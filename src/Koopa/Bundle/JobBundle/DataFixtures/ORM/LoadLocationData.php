<?php

namespace Koopa\Bundle\JobBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Koopa\Bundle\JobBundle\Entity\Location;

class LoadLocationData implements FixtureInterface, OrderedFixtureInterface
{

    protected $locations = array(
        array(
            'country' => 'Rep dem du congo',
            'town' => 'Kinshasa'
        ),
        array(
            'country' => 'Rep dem du congo',
            'town' => 'Matadi'
        ),
        array(
            'country' => 'Rep dem du congo',
            'town' => 'Katanga'
        ),
        array(
            'country' => 'Rep dem du congo',
            'town' => 'Boma'
        ),
        array(
            'country' => 'Republic du congo',
            'town' => 'Brazaville'
        ),
        array(
            'country' => 'Republic du congo',
            'town' => 'Point noir'
        ),
    );

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->locations as $l) {
            $location = (new Location())
                ->setCountry($l['country'])
                ->setTown($l['town']);

            $manager->persist($location);
        }

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 3;
    }
}
