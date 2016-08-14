<?php

namespace Koopa\Bundle\JobBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Koopa\Bundle\UserBundle\Entity\User;
use Koopa\Bundle\JobBundle\Entity\Job;
use Koopa\Bundle\JobBundle\Form\JobType;

/**
 * @Route("manager/jobs")
 */
class JobController extends Controller
{
    /**
     * find and display all jobs entities
     *
     * @Route("/", name="manager_job_jobs")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $jobs = $em->getRepository('KoopaJobBundle:Job')->all();
        $vm = $this->get('job_view_job_assembler')->createList($jobs, $leftJoin = true);

        return $this->render('admin/job/job/index.html.twig', compact('vm'));
    }

    /**
     * @Route("/new/{id}", name="manager_job_jobs_new")
     * @Method({"GET", "POST"})
     * @param User $user
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function newAction(User $user, Request $request)
    {
        $vm = $this->get('user_view_user_assembler')->create($user);
        $job = new Job();

        $job->setUser($user);
        $job->setActive(true);
        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', "job has been published");
            return $this->redirect($this->generateUrl('manager_job_jobs_show', array('id' => $job->getId())));
        }

        return $this->render(
            'admin/job/job/new.html.twig',
            array(
                'form' => $form->createView(),
                'vm' => $vm
            )
        );
    }


    /**
     * show a job
     *
     * @Route(
     * "/{id}",
     * name="manager_job_jobs_show",
     * requirements={
     * "id"="\d+"
     * }
     * )
     * @Method("GET")
     * @param Job $job
     * @return Response
     */
    public function showAction(Job $job)
    {
        $vm = $this->get('job_view_job_assembler')->create($job, 'show', $leftJoin = true);
        $deleteForm = $this->createDeleteForm($job);

        return $this->render('admin/job/job/show.html.twig', array(
            'vm' => $vm,
            'delete_form' => $deleteForm->createView()
        ));
    }


    /**
     * Displays a form to edit an existing Job entity.
     *
     * @Route("/{id}/edit", name="manager_job_jobs_edit")
     * @Method({"GET", "POST"})
     * @param Job $job
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function editAction(Job $job, Request $request)
    {
        $editForm   = $this->createForm(JobType::class, $job);
        $deleteForm = $this->createDeleteForm($job);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', "the Job has been updated !");

            return $this->redirect($this->generateUrl('manager_job_jobs'));
        }

        $vm = $this->get('job_view_job_assembler')->create($job, $action = 'edit');

        return $this->render(
            'admin/job/job/edit.html.twig',
            array(
                'vm'          => $vm,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a Job entity.
     *
     * @Route("/{id}", name="manager_job_jobs_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param Job $job
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Job $job)
    {
        $form = $this->createDeleteForm($job);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->remove($job);
            $em->flush();
        }

        return $this->redirectToRoute('manager_job_jobs');
    }

    /**
     * Creates a form to delete a Job entity by id.
     *
     * @param Job $job The Job object
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Job $job)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('manager_job_jobs_delete', array('id' => $job->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
