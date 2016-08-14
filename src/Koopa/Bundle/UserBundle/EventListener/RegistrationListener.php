<?php

namespace Koopa\Bundle\UserBundle\EventListener;

use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Listener responsible to change the role at before saving user
 */
class RegistrationListener implements EventSubscriberInterface
{
    /**
     * @var Symfony\Component\HttpFoundation\Session\Session
     */
    protected $session;

    /**
     * @var Symfony\Component\Routing\Generator\UrlGeneratorInterface
     */
    private $router;

    /**
     * Constructor
     *
     * @param Session $session
     */
    public function __construct(Session $session, UrlGeneratorInterface $router)
    {
        $this->session = $session;
        $this->router  = $router;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_INITIALIZE => 'onRegistrationInitialize',
            FOSUserEvents::REGISTRATION_COMPLETED  => 'onRegistrationICompleted',
            FOSUserEvents::REGISTRATION_SUCCESS    => 'onRegistrationSuccess',
        );
    }

    public function onRegistrationInitialize(UserEvent $event)
    {
        $role = $this->session->get('_role');
        $user = $event->getUser();

        if (!$role) {
            $url = $this->router->generate('users_join_us');
            $event->setResponse(new RedirectResponse($url));
        }

        $user->addRole($role);
        return true;
    }

    public function onRegistrationICompleted()
    {
        $this->session->remove('_role');
        return true;
    }

    /**
     * @param FormEvent $event
     */
    public function onRegistrationSuccess(FormEvent $event)
    {
        $url = $this->router->generate('pages_index');
        $event->setResponse(new RedirectResponse($url));
    }
}
