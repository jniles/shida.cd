<?php

namespace Koopa\Bundle\AppBundle\Util;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\ContainerInterface;

class RoleProvider
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param bool $all
     * @return ArrayCollection
     */
    public function getExistingRoles($all = true)
    {
        $theRoles = new ArrayCollection();
        $roleHierarchy = $this->container->getParameter('security.role_hierarchy.roles');
        $roles = array_keys($roleHierarchy);

        foreach($roles as $role) {
            $theRoles->set($role, $role);
        }

        if (false === $all) {
            $theRoles->remove('ROLE_ADMIN');
            $theRoles->remove('ROLE_SUPER_ADMIN');
        }

        return $theRoles;
    }
}
