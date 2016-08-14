<?php

namespace Koopa\Bundle\JobBundle\Controller;

use Koopa\Bundle\JobBundle\Entity\Subscription;
use Koopa\Bundle\JobBundle\Entity\Job;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionController extends Controller
{
    /**
     * @Route("demandeur/subscribe/{id}", name="job_subscriptions_subscribe")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Job $job
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request, Job $job)
    {
        $form = $this->createCreateForm($job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $subscription = new Subscription();
            $subscription->setUser($this->getUser());
            $subscription->setJob($job);

            $subscriptionManager = $this->get('koopa_job.subscription_manager');

            try {
                $subscriptionManager->save($subscription);
            } catch (\Exception $e) {
                $this->get('session')->getFlashBag()->add('danger', $e->getMessage());

                return $this->redirectToRoute('pages_index');
            }


            $this->get('session')->getFlashBag()->add('success', "inscription réussi");

            return $this->redirectToRoute('pages_index');
        }

        return $this->render(
            'job/subscription/new.html.twig',
            array('form' => $form->createView())
        );
    }

    public function createCreateForm(Job $job)
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('job_subscriptions_subscribe', array('id' => $job->getId())))
            ->setMethod('POST')
            ->getForm();

        return $form;
    }
}
