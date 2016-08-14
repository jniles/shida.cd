<?php

namespace Koopa\Bundle\JobBundle\Doctrine;

use Doctrine\ORM\EntityManager;
use Koopa\Bundle\JobBundle\Entity\Subscription;

class SubscriptionManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {

        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository('KoopaJobBundle:Subscription');
    }

    /**
     * @param Subscription $subscription
     * @throws \Exception
     */
    public function save(Subscription $subscription)
    {
        $userId = $subscription->getUser()->getId();
        $jobId = $subscription->getJob()->getId();

        if ($this->repository->isSubscribed($userId, $jobId)) {
            throw new \Exception("vous vous êtes déjà souscri sur cet offre");
        }

        $this->entityManager->persist($subscription);
        $this->entityManager->flush();
    }
}
