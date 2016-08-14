<?php

namespace Koopa\Bundle\UserBundle\Assembler;

use Koopa\Bundle\UserBundle\ViewModel\ViewUser;
use Koopa\Bundle\UserBundle\Entity\User;
use Koopa\Bundle\JobBundle\Assembler\ViewJobAssembler;

class ViewUserAssembler
{
    public function create(User $user, $action = 'show', $leftJoin = false)
    {
        $vm               = new ViewUser();
        $vm->id           = $user->getId();
        $vm->username     = $user->getUsername();
        $vm->firstname    = $user->getFirstname();
        $vm->lastname     = $user->getLastName();
        $vm->gender       = $user->getGender();
        $vm->fullName     = $user->getFullName();
        $vm->email        = $user->getEmail();
        $vm->jobPublished = $user->getJobs()->count();
        $vm->pageTitle    = 'à propos de ' . $user->getFullName();
        $vm->image        = $user->getImage();

        if ($user->isEnabled()) {
            $vm->enabled = '<span class="label label-success">yes</span>';
        } else {
            $vm->enabled = '<span class="label label-danger">no</span>';
        }

        if (true === $leftJoin) {
            foreach ($user->getJobs() as $job) {
                $viewJob = new ViewJobAssembler();
                $viewJob = $viewJob->create($job);

                $vm->jobs[] = $viewJob;
            }
        }

        return $vm;
    }

    public function createList(array $users)
    {
        $vm = new ViewUser;
        $vm->pageTitle = 'lists of users';

        foreach ($users as $user) {
            $person               = new ViewUser();
            $person->id           = $user->getId();
            $person->username     = $user->getUsername();
            $person->email        = $user->getEmail();
            $person->jobPublished = $user->getJobs()->count();

            if ($user->isEnabled()) {
                $person->enabled = '<span class="label label-success">yes</span>';
            } else {
                $person->enabled = '<span class="label label-danger">no</span>';
            }

            $vm->collections[] = $person;
        }

        return $vm;
    }
}
