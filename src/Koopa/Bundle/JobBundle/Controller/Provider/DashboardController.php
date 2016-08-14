<?php


namespace Koopa\Bundle\JobBundle\Controller\Provider;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/provider")
 */
class DashboardController extends Controller
{
    /**
     * @Route("/", name="provider_home")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('provider/index.html.twig');
    }
}
