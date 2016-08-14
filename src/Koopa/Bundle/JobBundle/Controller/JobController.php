<?php

namespace Koopa\Bundle\JobBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Koopa\Bundle\JobBundle\Entity\Job;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("jobs")
 */
class JobController extends Controller
{
    /**
     * show all jobs
     * @Route("/", name="jobs_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $jobsQuery = $this->getDoctrine()->getManager()->getRepository('KoopaJobBundle:Job')->fetchAll();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $jobsQuery,
            $request->query->getInt('page', 1),
            60
        );

        $vm   = $this->get('job_view_job_assembler')->createList($pagination, $leftJoin = true);

        return $this->render('job/job/index.html.twig', compact('vm', 'pagination'));
    }

    /**
     * show a specific job
     * @Route(
     * "/{slug}",
     * name="jobs_show",
     * requirements={"slug"="[0-9a-z-]+"}
     * )
     * @Method("GET")
     * @param Job $job
     * @return \Symfony\Component\HttpFoundation\Response
     * @ParamConverter(name="job", class="KoopaJobBundle:Job", options={"repository_method": "fetch", "slug": "slug"})
     */
    public function showAction(Job $job)
    {
        $vm   = $this->get('job_view_job_assembler')->create($job, $action = 'show', $leftJoin = true);

        return $this->render('job/job/show.html.twig', compact('vm'));
    }
}
