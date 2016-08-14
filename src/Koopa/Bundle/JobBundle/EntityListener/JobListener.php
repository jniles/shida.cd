<?php

namespace Koopa\Bundle\JobBundle\EntityListener;

use Koopa\Bundle\JobBundle\Entity\Job;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Mapping as ORM;

class JobListener
{
    /** @ORM\PrePersist */
    public function prePersistHandler(Job $job, LifecycleEventArgs $event)
    {
    }

    /** @ORM\PostPersist */
    public function postPersistHandler(Job $job, LifecycleEventArgs $event)
    {
        $manager = $event->getEntityManager();
        $job->setSlug($job->getSlug() . '-' . $job->getId());

        $manager->flush();
    }

    /** @ORM\PreUpdate */
    public function preUpdateHandler(Job $job, PreUpdateEventArgs $event)
    {
    }

    /** @ORM\PostUpdate */
    public function postUpdateHandler(Job $job, LifecycleEventArgs $event)
    {
    }

    /** @ORM\PostRemove */
    public function postRemoveHandler(Job $job, LifecycleEventArgs $event)
    {
    }

    /** @ORM\PreRemove */
    public function preRemoveHandler(Job $job, LifecycleEventArgs $event)
    {
    }

    /** @ORM\PreFlush */
    public function preFlushHandler(Job $job, PreFlushEventArgs $event)
    {
    }

    /** @ORM\PostLoad */
    public function postLoadHandler(Job $job, LifecycleEventArgs $event)
    {
    }
}
