<?php

namespace Koopa\Bundle\JobBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Koopa\Bundle\JobBundle\Entity\Location;
use Koopa\Bundle\JobBundle\Form\LocationType;

/**
 *
 *
 * @Route("/manager/job/locations")
 */
class LocationController extends Controller
{
    /**
     * index all location
     *
     * @Route("/", name="manager_job_locations")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $locations = $em->getRepository('KoopaJobBundle:Location')->findAll();
        $vm = $this->get('job_view_location_assembler')->createList($locations);

        return $this->render('admin/job/location/index.html.twig', compact('vm'));
    }

    /**
     * index all location
     *
     * @Route(
     * "/{id}",
     * name="manager_job_locations_show",
     * requirements={
     * "id"="\d+"
     * }
     * )
     * @Method("GET")
     * @param Location $location
     * @return Response
     */
    public function showAction(Location $location)
    {
        $deleteForm = $this->createDeleteForm($location);
        $vm = $this->get('job_view_location_assembler')->create($location, 'show');

        return $this->render('admin/job/location/show.html.twig', array(
            'vm' => $vm,
            'delete_form' => $deleteForm->createView()
        ));
    }


    /**
     * create a new location
     *
     * @Route("/new", name="manager_job_locations_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $location = new Location();
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($location);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', "the location has been saved !");

            return $this->redirect($this->generateUrl('manager_job_locations'));
        }

        $vm = $this->get('job_view_location_assembler')->create($location);

        return $this->render(
            'admin/job/location/new.html.twig',
            array(
                'form' => $form->createView(),
                'vm'   => $vm
            )
        );
    }

    /**
     * Displays a form to edit an existing location entity.
     *
     * @Route("/{id}/edit", name="manager_job_locations_edit")
     * @Method({"GET", "POST"})
     * @param Location $location
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Location $location, Request $request)
    {
        $editForm   = $this->createForm(LocationType::class, $location);
        $deleteForm = $this->createDeleteForm($location);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', "the location has been updated !");

            return $this->redirect($this->generateUrl('manager_job_locations'));
        }

        $vm = $this->get('job_view_location_assembler')->create($location, $action = 'edit');

        return $this->render(
            'admin/job/location/edit.html.twig',
            array(
                'vm'          => $vm,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a location entity.
     *
     * @Route("/{id}", name="manager_job_locations_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param Location $location
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Location $location)
    {
        $form = $this->createDeleteForm($location);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->remove($location);
            $em->flush();
        }

        return $this->redirectToRoute('manager_job_locations');
    }

    /**
     * Creates a form to delete a location entity by id.
     *
     * @param location $location The location object
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(location $location)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('manager_job_locations_delete', array('id' => $location->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
