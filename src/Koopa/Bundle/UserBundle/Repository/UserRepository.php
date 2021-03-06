<?php

namespace Koopa\Bundle\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Koopa\Bundle\UserBundle\Entity\User;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
    public function fetchByRole($role)
    {
        $role = strtoupper('role_' . $role);
        return $this->createQueryBuilder('u')
            ->where("u.roles LIKE '%$role%'")
            ->getQuery()->getResult();
    }

    /**
     * @param User $user
     * @param string $role
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getStats(User $user, $role = 'role_advertiser')
    {
        if ('ROLE_ADVERTISER' == strtoupper($role)) {
            $query = $this->_em->createQuery('
                select count(j.id) as nbr_jobs, count(s.id) as nbr_subscriptions from KoopaJobBundle:Job j
                left join j.subscriptions s
                where j.user = :userId
            ')->setParameter('userId', $user->getId());

            $result = $query->getScalarResult();
            return $result[0];
        }
    }
}
