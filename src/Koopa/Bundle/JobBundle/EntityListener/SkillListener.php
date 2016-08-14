<?php

namespace Koopa\Bundle\JobBundle\EntityListener;

use Doctrine\ORM\Mapping as ORM;
use Koopa\Bundle\JobBundle\Entity\Skill;
use Doctrine\ORM\Event\LifecycleEventArgs;

class SkillListener
{
    /**
     * @ORM\PostPersist
     * @param  Skill              $skill
     * @param  LifecycleEventArgs $event
     */
    public function postPersistHandler(Skill $skill, LifecycleEventArgs $event)
    {
        $manager = $event->getEntityManager();
        $skill->setSlug($skill->getSlug() . '-' . $skill->getId());

        $manager->flush();
    }
}
