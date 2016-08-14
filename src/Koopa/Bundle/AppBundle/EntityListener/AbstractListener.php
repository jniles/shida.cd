<?php

namespace Koopa\Bundle\AppBundle\EntityListener;

use Koopa\Bundle\AppBundle\Entity\Other;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Mapping as ORM;

abstract class AbstractListener
{
    /** @ORM\PrePersist */
    public function prePersistHandler(Other $entity, LifecycleEventArgs $event)
    {
    }

    /** @ORM\PostPersist */
    public function postPersistHandler(Other $entity, LifecycleEventArgs $event)
    {
    }

    /** @ORM\PreUpdate */
    public function preUpdateHandler(Other $entity, PreUpdateEventArgs $event)
    {
    }

    /** @ORM\PostUpdate */
    public function postUpdateHandler(Other $entity, LifecycleEventArgs $event)
    {
    }

    /** @ORM\PostRemove */
    public function postRemoveHandler(Other $entity, LifecycleEventArgs $event)
    {
    }

    /** @ORM\PreRemove */
    public function preRemoveHandler(Other $entity, LifecycleEventArgs $event)
    {
    }

    /** @ORM\PreFlush */
    public function preFlushHandler(Other $entity, PreFlushEventArgs $event)
    {
    }

    /** @ORM\PostLoad */
    public function postLoadHandler(Other $entity, LifecycleEventArgs $event)
    {
    }
}
