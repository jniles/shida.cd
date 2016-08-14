<?php

namespace Koopa\Bundle\JobBundle\Controller\Advertiser;

use Koopa\Bundle\JobBundle\Entity\Subscription;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class SubscriptionController
 * @package Koopa\Bundle\JobBundle\Controller\Advertiser
 * @Route("/offreur/jobs")
 */
class SubscriptionController extends Controller
{
    /**
     * @param Subscription $subscription
     * @return RedirectResponse
     * @internal param Request $request
     * @Route("/subscribe/accept/{id}", name="advertiser_subscriptions_accept")
     * @Method("GET")
     */
    public function acceptUserAction(Subscription $subscription)
    {
        $em = $this->getDoctrine()->getManager();
        $subscription->setAccept(true);
        $em->flush();

        $username = $subscription->getUser()->getUsername();
        $this->addFlash('success', "Le demandeur $username a bien été accepter");

        return $this->redirectToRoute('advertiser_jobs_index');
    }

    /**
     * @param Subscription $subscription
     * @return RedirectResponse
     * @internal param Request $request
     * @Route("/subscribe/decline/{id}", name="advertiser_subscriptions_decline")
     * @Method("GET")
     */
    public function declinetUserAction(Subscription $subscription)
    {
        $em = $this->getDoctrine()->getManager();
        $subscription->setAccept(false);
        $em->flush();

        $username = $subscription->getUser()->getFullName();
        $this->addFlash('success', "Le demandeur $username a bien été refuser");

        return $this->redirectToRoute('advertiser_jobs_index');
    }
}
