<?php

namespace Koopa\Bundle\JobBundle\EntityListener;

use Doctrine\ORM\Mapping as ORM;
use Koopa\Bundle\JobBundle\Entity\Base;
use Doctrine\ORM\Event\LifecycleEventArgs;

class BaseListener
{
    /** @ORM\PrePersist */
    public function prePersistHandler(Base $base, LifecycleEventArgs $event)
    {
    }

    /** @ORM\PostPersist */
    public function postPersistHandler(Base $base, LifecycleEventArgs $event)
    {
    }

    /** @ORM\PreUpdate */
    public function preUpdateHandler(Base $base, PreUpdateEventArgs $event)
    {
    }

    /** @ORM\PostUpdate */
    public function postUpdateHandler(Base $base, LifecycleEventArgs $event)
    {
    }

    /** @ORM\PreRemove */
    public function preRemoveHandler(Base $base, LifecycleEventArgs $event)
    {
    }

    /** @ORM\PostRemove */
    public function postRemoveHandler(Base $base, LifecycleEventArgs $event)
    {
    }


    /** @ORM\PreFlush */
    public function preFlushHandler(Base $base, PreFlushEventArgs $event)
    {
    }

    /** @ORM\PostLoad */
    public function postLoadHandler(Base $base, LifecycleEventArgs $event)
    {
    }
}
