<?php

namespace Koopa\Bundle\JobBundle\ViewModel;

class ViewSubscription
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var \DateTime
     */
    public $createdAt;

    /**
     * @var boolean
     */
    public $accept;

    /**
     * @var ViewUser
     */
    public $user;

    /**
     * @var array
     */
    public $collections;
}
