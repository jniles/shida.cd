<?php

namespace Koopa\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Koopa\Bundle\UserBundle\Entity\User;
use Koopa\Bundle\UserBundle\ViewModel\ViewUser;

/**
 * @Route("/offreur")
 */
class AdvertiserController extends Controller
{
    /**
     * @Route("/", name="advertisers_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $stats = $this->getDoctrine()->getRepository('KoopaUserBundle:User')->getStats($this->getUser());

        return $this->render('advertiser/index.html.twig', compact('stats'));
    }

    /**
     * @param User $user
     * @Route("/users/{username}/{subscription_id}", name="advertiser_users_show")
     * @Method("GET")
     * @param integer $subscription_id
     * @return Response
     */
    public function shwoUserProfile(User $user, $subscription_id)
    {
        $vm = $this->get('user_view_user_assembler')->create($user, 'show', $leftJoin = true);
        $subscription = $this->getDoctrine()
            ->getRepository('KoopaJobBundle:Subscription')
            ->find($subscription_id)
        ;
        $approbation = $subscription->getAccept();

        $vm = $this->toggleApprobation($vm, $approbation, $subscription_id);

        return $this->render('advertiser/user/show.html.twig', array('vm' => $vm));
    }

    /**
     * [toggleApprobation description]
     *
     * @param  ViewUserAssembler $vm
     * @param  boolean           $approbation
     * @param  integer           $subscription_id
     * @return ViewUserAssembler
     */
    protected function toggleApprobation(ViewUser $vm, $approbation, $subscription_id)
    {
        if ($approbation) {
            $vm->isNotAccepted = false;
            $vm->action = $this->generateUrl(
                'advertiser_subscriptions_decline',
                array('id' => $subscription_id)
            );
        } else {
            $vm->isNotAccepted = true;
            $vm->action = $this->generateUrl(
                'advertiser_subscriptions_accept',
                array('id' => $subscription_id)
            );
        }

        return $vm;
    }
}
