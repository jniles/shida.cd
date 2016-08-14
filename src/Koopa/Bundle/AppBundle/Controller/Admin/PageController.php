<?php

namespace Koopa\Bundle\AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/manager")
 */
class PageController extends controller
{
    /**
     * Show the index page admin
     *
     * @Route("/", name="admin_pages_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('admin/page/index.html.twig');
    }
}
