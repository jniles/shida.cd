<?php


namespace Koopa\Bundle\JobBundle\Controller\Immoffreur;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/immoffreur")
 */
class DashboardController extends Controller
{
    /**
     * @Route("/", name="immoffreur_home")
     * @Method("GET")
     * @return [type] [description]
     */
    public function indexAction()
    {
        return $this->render('immoffreur/index.html.twig');
    }
}
