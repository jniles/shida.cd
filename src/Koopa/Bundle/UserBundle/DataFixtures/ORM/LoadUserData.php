<?php

namespace Koopa\Bundle\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Koopa\Bundle\UserBundle\Entity\User;

class LoadUserData implements FixtureInterface, OrderedFixtureInterface
{

    protected $users = [
        [
            'email' => 'jean@domain.io',
            'username' => 'jean',
            'password' => '0000',
            'role' => 'role_applicant'
        ],
        [
            'email' => 'jeane@domain.io',
            'username' => 'jeane',
            'password' => '0000',
            'role' => 'role_applicant'
        ],
        [
            'email' => 'jose@domain.io',
            'username' => 'jose',
            'password' => '0000',
            'role' => 'role_advertiser'
        ],
        [
            'email' => 'dieu@domain.io',
            'username' => 'dieu',
            'password' => '0000',
            'role' => 'role_immo'
        ],
        [
            'email' => 'david@domain.io',
            'username' => 'david',
            'password' => '0000',
            'role' => 'role_all'
        ],
        [
            'email' => 'mano@domain.io',
            'username' => 'mano',
            'password' => '0000',
            'role' => 'role_manager'
        ],
        [
            'email' => 'admin@domain.io',
            'username' => 'admin',
            'password' => '0000',
            'role' => 'role_admin'
        ],
    ];

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->users as $user) {
            $person = new User();
            $person->setUsername($user['username']);
            $person->setPlainPassword($user['password']);
            $person->setEmail($user['email']);
            $person->addRole($user['role']);

            $manager->persist($person);
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
        return 1;
    }
}
