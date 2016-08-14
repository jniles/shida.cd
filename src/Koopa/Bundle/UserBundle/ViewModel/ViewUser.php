<?php

namespace Koopa\Bundle\UserBundle\ViewModel;

class ViewUser
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $email;

    /**
     * @var boolean
     */
    public $enabled;

    /**
     * @var integer
     */
    public $jobPublished;

    /**
     * @var \DateTime
     */
    public $lastLogin;

    /**
     * @var array
     */
    public $roles;

    /**
     * @var array
     */
    public $jobs;

    /**
     * @var array
     */
    public $skills;

    /**
     * @var array
     */
    public $collections;

    /**
     * @var string
     */
    public $firstname;

    /**
     * @var string
     */
    public $lastname;

    /**
     * @var string
     */
    public $gender;

    /**
     * @var string
     */
    public $fullName;

    /**
     * @var Koopa\Bundle\AppBundle\Entity\Image
     */
    public $image;

}
