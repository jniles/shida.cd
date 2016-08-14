<?php


namespace Koopa\Bundle\JobBundle\Controller\Advertiser;


use Koopa\Bundle\JobBundle\Form\JobType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Koopa\Bundle\JobBundle\Entity\Job;

/**
 * Class JobController
 * @package Koopa\Bundle\JobBundle\Controller\Advertiser
 * @Route("/offreur/jobs")
 */
class JobController extends Controller
{
    /**
     * @Route("/", name="advertiser_jobs_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getId();
        $jobs = $em->getRepository('KoopaJobBundle:Job')->fetchAllByUser($userId);
        $vm = $this->get('job_view_job_assembler')->createList($jobs, $leftJoin = true);

        return $this->render('advertiser/job/index.html.twig', compact('vm'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     * @Route("/new", name="advertiser_jobs_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $job = new Job();
        $job->setUser($this->getUser());
        $form = $this->createForm(JobType::class, $job);
        $form->remove('active');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', "job has been created !");

            return $this->redirectToRoute('advertiser_jobs_index');
        }

        $vm = $this->get('job_view_job_assembler')->create($job);

        return $this->render('advertiser/job/new.html.twig', array(
            'vm' => $vm,
            'form' => $form->createView()
        ));
    }


    /**
     * @param Job $job
     * @return Response
     * @Route("/{slug}", name="advertiser_jobs_show", requirements={"slug"="[a-z0-9-]+"})
     * @Method("GET")
     * @ParamConverter(name="job", class="KoopaJobBundle:Job", options={"repository_method": "fetchByUser", "slug": "slug"})
     */
    public function showAction(Job $job)
    {
        $vm = $this->get('job_view_job_assembler')->create($job, 'show', $leftJoin = true);
        $deleteForm = $this->createDeleteForm($job);

        return $this->render('advertiser/job/show.html.twig', array(
            'vm' => $vm,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @param Request $request
     * @param Job $job
     * @return RedirectResponse|Response
     * @Route("/{id}/edit", name="advertiser_jobs_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Job $job)
    {
        $editForm = $this->createForm(JobType::class, $job);
        $editForm->remove('active');
        $deleteForm = $this->createDeleteForm($job);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'job has been updated.');

            return $this->redirectToRoute('advertiser_jobs_show', array('slug' => $job->getSlug()));
        }

        $vm = $this->get('job_view_job_assembler')->create($job, 'edit');
        return $this->render('advertiser/job/edit.html.twig', array(
            'edit_form' => $editForm->createView(),
            'vm' => $vm,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @param Request $request
     * @Route("/{id}", name="advertiser_jobs_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
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

            $this->get('session')->getFlashBag()->add('success', 'job has been deleted.');

            return $this->redirectToRoute('advertiser_jobs_index');
        }
    }

    /**
     * @param Job $job
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm(Job $job)
    {
        return $this->createFormBuilder()
            ->setMethod('DELETE')
            ->setAction($this->generateUrl('advertiser_jobs_delete', array('id' => $job->getId())))
            ->getForm();
    }
}
