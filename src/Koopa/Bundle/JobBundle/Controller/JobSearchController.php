<?php

namespace Koopa\Bundle\JobBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Koopa\Bundle\JobBundle\Entity\Job;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("search/q")
 */
class JobSearchController extends Controller
{
    /**
     * show all jobs
     * @Route("", name="jobs_search_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $categories = $request->query->get('categories');
        $locations = $request->query->get('locations');

        if (!is_array($categories)) {
            $categories = array();
        }

        if (!is_array($locations)) {
            $locations = array();
        }

        $jobsQuery = $this->getDoctrine()->getManager()
            ->getRepository('KoopaJobBundle:Job')
            ->search($categories, $locations);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $jobsQuery,
            $request->query->getInt('page', 1),
            100
        );

        $vm   = $this->get('job_view_job_assembler')->createList($pagination, $leftJoin = true);

        return $this->render('job/job/result.html.twig', compact('vm', 'pagination'));
    }

    public function keywordAction($template)
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('KoopaJobBundle:SubCategory')->findAll();
        $locations = $em->getRepository('KoopaJobBundle:Location')->findAll();

        if ('homepage' === $template) {
            return $this->render('job/job/search_layout_homepage.html.twig', array(
                'categories' => $categories,
                'locations' => $locations
            ));
        }

        return $this->render('job/job/search_layout.html.twig', array(
            'categories' => $categories,
            'locations' => $locations
        ));
    }
}
