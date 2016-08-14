<?php

namespace Koopa\Bundle\JobBundle\Assembler;

use Koopa\Bundle\AppBundle\Assembler\AbstractAssembler;

use Koopa\Bundle\JobBundle\ViewModel\ViewSkill;
use Koopa\Bundle\JobBundle\Entity\Skill;

class ViewSkillAssembler extends AbstractAssembler
{
    public function create(Skill $skill, $action = 'create', $leftJoin = false)
    {
        $viewSkill            = new ViewSkill();
        $viewSkill->id        = $skill->getId();
        $viewSkill->name      = $skill->getName();

        if ('show' === $action || 'edit' === $action) {
            $viewSkill->pageTitle = $this->setPageTitle(
                $skill->getName(),
                $action
            );
        } else {
            $viewSkill->pageTitle = $this->setPageTitle('skill');
        }

        return $viewSkill;
    }

    public function createList(array $skills)
    {
        $viewSkill            = new ViewSkill();
        $viewSkill->pageTitle = 'lists of Skill';

        foreach ($skills as $skill) {
            $vSkill       = new ViewSkill();
            $vSkill->id   = $skill->getId();
            $vSkill->name = $skill->getName();

            $viewSkill->collections[] = $vSkill;
        }

        return $viewSkill;
    }
}
