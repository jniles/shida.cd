<?php

namespace Koopa\Bundle\JobBundle\Assembler;

use Koopa\Bundle\AppBundle\Assembler\AbstractAssembler;

use Koopa\Bundle\JobBundle\ViewModel\ViewJob;
use Koopa\Bundle\JobBundle\Entity\Job;
use Koopa\Bundle\UserBundle\Assembler\ViewUserAssembler;
use Koopa\Bundle\JobBundle\Assembler\ViewSkillAssembler;
use Koopa\Bundle\JobBundle\Assembler\ViewLocationAssembler;
use Koopa\Bundle\JobBundle\Assembler\ViewSubCategoryAssembler;

class ViewJobAssembler extends AbstractAssembler
{
    protected $vmUserAssembler;
    protected $vmSkillAssembler;
    protected $vmLocationAssembler;
    protected $vmSubCategoryAssembler;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->vmUserAssembler        = new ViewUserAssembler();
        $this->vmSkillAssembler       = new ViewSkillAssembler();
        $this->vmLocationAssembler    = new ViewLocationAssembler();
        $this->vmSubCategoryAssembler = new ViewSubCategoryAssembler();
        $this->vmSubscriptionAssembler = new ViewSubscriptionAssembler($this->vmUserAssembler);
    }

    /**
     * @param Job $job
     * @param string $action
     * @param bool $leftJoin
     * @return ViewJob
     */
    public function create(Job $job, $action = 'create', $leftJoin = false)
    {
        $vm                = new ViewJob();
        $vm->id            = $job->getId();
        $vm->title         = $job->getTitle();
        $vm->slug          = $job->getSlug();
        $vm->salary        = $job->getSalary();
        $vm->paymentMehtod = $job->getPaymentMethod();
        $vm->summary       = $job->getSummary();
        $vm->createdAt     = $job->getCreatedAt();
        $vm->startAt       = $job->getStartAt();
        $vm->timeLeft      = $job->getTimeLeft();
        $vm->active        = $job->getActive();

        if (true === $leftJoin) {
            $vm->user          = $this->vmUserAssembler->create($job->getUser());

            $vm->skills        = $this->vmSkillAssembler->createList($job->getSkills()->toArray());
            $vm->locations     = $this->vmLocationAssembler->createList($job->getLocations()->toArray());
            $vm->subCategories = $this->vmSubCategoryAssembler->createList($job->getSubCategories()->toArray());
            $vm->subscriptions = $this->vmSubscriptionAssembler->createList($job->getSubscriptions()->toArray());
        }


        if ('show' === $action || 'edit' === $action) {
            $vm->pageTitle = $this->setPageTitle(
                $job->getTitle(),
                $action
            );
        } else {
            $vm->pageTitle = $this->setPageTitle('Job');
        }

        return $vm;
    }

    /**
     * @param \IteratorAggregate $jobs
     * @param bool $leftJoin
     * @return ViewJob
     */
    public function createList($jobs, $leftJoin = false, $groupByMonth = false)
    {
        $vm            = new ViewJob();
        $vm->pageTitle = 'lists of jobs';

        if (true === $leftJoin) {
            foreach ($jobs as $job) {
                $vm->collections[] = $this->create($job, null, $leftJoin);
            }
        } else {
            foreach ($jobs as $job) {
                $vm->collections[] = $this->create($job);
            }
        }

        if (true === $groupByMonth) {
            $vm->collections = $this->groupByMonth($vm->collections);
        }

        return $vm;
    }

    /**
     * Group viewModel by month
     *
     * @param mixed $data
     * @return array
     */
    public function groupByMonth($data)
    {
        $collections = array();
        $lastKey = false;

        foreach ($data as $key => $job) {
            if (0 === $key) {
                if ($job instanceof Job) {
                    $lastKey = $job->getCreatedAt()->format('m-Y');
                } else {
                    $lastKey = $job->createdAt->format('m-Y');
                }

                $collections[$lastKey] = array(
                    $job
                );
            } else {
                if ($job instanceof Job) {
                    $lastKey = $job->getCreatedAt()->format('m-Y');
                } else {
                    $lastKey = $job->createdAt->format('m-Y');
                }

                if (array_key_exists($lastKey, $collections)) {
                    $collections[$lastKey][] = $job;
                } else {
                    $collections[$lastKey] = array(
                        $job
                    );
                }
            }
        }

        return $collections;
    }
}
