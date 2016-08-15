<?php

namespace Koopa\Bundle\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;

class PageController extends Controller
{
    /**
     * Show home page
     *
     * @Route("/", name="pages_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $jobsQuery = $this->getDoctrine()->getManager()->getRepository('KoopaJobBundle:Job')->fetchAll();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $jobsQuery,
            $request->query->getInt('page', 1),
            7
        );

        $vm = $this->get('job_view_job_assembler')->groupByMonth($pagination);

        return $this->render('page/index.html.twig', array('pagination' => $pagination, 'vm' => $vm));
    }

    /**
     * Show the contact page
     *
     * @Route("/contact", name="pages_contact")
     * @Method("GET")
     */
    public function contactAction()
    {
        $content = 'Contact me on <a mailto="contact@lerecruteur.cd">contact@lerecruteur.cd</a>';

        return new Response($content);
    }

    /**
     * Show employer page
     *
     * @Route("/employer", name="pages_employer")
     * @Method("GET")
     */
    public function employerAction()
    {
        return $this->render('page/employer.html.twig');
    }

    /**
     * Show applicant|candidat page
     *
     * @Route("/applicant", name="pages_applicant")
     * @Method("GET")
     */
    public function applicantAction()
    {
        return $this->render('page/applicant.html.twig');
    }

    public function sidebarAction()
    {
        return $this->render('page/sidebar.html.twig');
    }

    /**
     * Result page
     *
     * @Route("/search", name="search")
     * @Method("GET")
     */
    public function searchAction(Request $request)
    {
        $q = $request->get('q', false);
        $q .= ' ' . $request->get('l', false);
        $finder = $this->get('fos_elastica.finder.app');
        $result = [];

        if ($q) {
            $result = $finder->find($q);
        }

        return $this->render('page/result.html.twig', ['records' => $result, 'q' => $q]);
    }
}
