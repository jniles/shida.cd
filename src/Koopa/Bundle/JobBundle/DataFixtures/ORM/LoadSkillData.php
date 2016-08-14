<?php

namespace Koopa\Bundle\JobBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Koopa\Bundle\JobBundle\Entity\Skill;

class LoadSkillData implements FixtureInterface, OrderedFixtureInterface
{

    protected $skills = array(
        array('name' => 'Web developer'),
        array('name' => 'Human resources'),
        array('name' => 'Doctor'),
        array('name' => 'Writer'),
    );

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->skills as $s) {
            $skill = (new Skill())->setName($s['name']);

            $manager->persist($skill);
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
        return 4;
    }
}
