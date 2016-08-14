<?php

namespace Koopa\Bundle\JobBundle\ViewModel;

class ViewJob
{
    /**
     * @var string
     */
    public $pageTitle;

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $active;

    /**
     * @var string
     */
    public $slug;

    /**
     * @var string
     */
    public $paymentMethod;

    /**
     * @var float
     */
    public $salary;

    /**
     * @var string
     */
    public $summary;

    /**
     * @var \DateTime
     */
    public $createdAt;

    /**
     * @var \DateTime
     */
    public $startAt;

    /**
     * @var \DateTime
     */
    public $timeLeft;

    /**
     * @var Koopa\Bundle\UserBundle\ViewModel\ViewUser
     */
    public $user;

    /**
     * @var array
     */
    public $skills;

    /**
     * @var array
     */
    public $locations;

    /**
     * @var array
     */
    public $subCategories;

    /**
     * @var array
     */
    public $subscriptions;

    /**
     * @var array
     */
    public $collections;
}
