<?php

namespace Koopa\Bundle\UserBundle\Controller;

use Koopa\Bundle\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class UserRegistrationController extends Controller
{
    /**
     * Show join us page
     *
     * @Route("/join-us", name="users_join_us")
     * @Method("GET")
     * @return Response
     */
    public function joinUsAction()
    {
        return $this->render('user/join_us.html.twig');
    }

    /**
     * Redirect for create a specific account
     *
     * @Route("/signin", name="users_signin")
     * @Method("GET")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function signinAction(Request $request)
    {
        $role = 'role_' . $request->query->get('_as');
        $roles = array(User::ROLE_ADVERTISER, User::ROLE_APPLICANT, User::ROLE_IMMO, User::ROLE_ALL);
        $session = $this->get('session');

        if (!in_array($role, $roles, $strict = true)) {
            return $this->redirectToRoute('users_join_us');
        }

        $session->set('_role', $role);
        return $this->redirectToRoute('fos_user_registration_register', array(), Response::HTTP_FOUND);
    }
}
