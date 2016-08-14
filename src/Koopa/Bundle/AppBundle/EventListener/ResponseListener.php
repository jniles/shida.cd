<?php

namespace Koopa\Bundle\AppBundle\EventListener;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Koopa\Bundle\AppBundle\Util\HtmlModify;

class ResponseListener implements EventSubscriberInterface
{
    protected $htmlModify;

    public function __construct(HtmlModify $htmlModify)
    {
        $this->htmlModify = $htmlModify;
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::RESPONSE => 'onResponse'
        );
    }

    public function onResponse(FilterResponseEvent $event)
    {
        // $response = $this->htmlModify->modify($event->getResponse());
        // $event->setResponse($response);
    }
}
