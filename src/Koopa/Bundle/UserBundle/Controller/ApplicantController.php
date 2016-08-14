<?php

namespace Koopa\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Koopa\Bundle\UserBundle\Entity\User;

/**
 * @Route("/demandeur")
 */
class ApplicantController extends Controller
{
    /**
     * @Route("/", name="applicants_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('KoopaJobBundle:Subscription');
        $user = $this->getUser();

        $totalSubscriptions = $repository->count($user);
        $acceptedSubscriptions = $repository->count($user, $accpted = true);

        return $this->render('applicant/index.html.twig', array(
            'total_subscribed' => $totalSubscriptions,
            'accepted_subscribed' => $acceptedSubscriptions,
        ));
    }
}
