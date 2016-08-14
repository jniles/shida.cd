<?php

namespace Koopa\Bundle\JobBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Koopa\Bundle\JobBundle\Entity\SubCategory;
use Koopa\Bundle\JobBundle\Form\SubCategoryType;

/**
 *
 *
 * @Route("/manager/job/subcategories")
 */
class SubCategoryController extends Controller
{
    /**
     * index all SubCategory
     *
     * @Route("/", name="manager_job_subcategories")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $subCategories = $em->getRepository('KoopaJobBundle:SubCategory')->findAll();
        $vm = $this->get('job_view_subcategory_assembler')->createList($subCategories);

        return $this->render('admin/job/subcategory/index.html.twig', compact('vm'));
    }

    /**
     * show a Subcategory
     *
     * @Route(
     * "/{id}",
     * name="manager_job_subcategories_show",
     * requirements={
     * "id"="\d+"
     * }
     * )
     * @Method("GET")
     * @param SubCategory $subcategory
     * @return Response
     */
    public function showAction(SubCategory $subcategory)
    {
        $deleteForm = $this->createDeleteForm($subcategory);
        $vm = $this->get('job_view_subcategory_assembler')->create($subcategory, 'show');

        return $this->render('admin/job/subcategory/show.html.twig', array(
            'vm' => $vm,
            'delete_form' => $deleteForm->createView()
        ));
    }


    /**
     * create a new SubCategory
     *
     * @Route("/new", name="manager_job_subcategories_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $Subcategory = new SubCategory();
        $form = $this->createForm(SubCategoryType::class, $Subcategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Subcategory);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', "the SubCategory has been saved !");

            return $this->redirect($this->generateUrl('manager_job_subcategories'));
        }

        $vm = $this->get('job_view_subcategory_assembler')->create($Subcategory);

        return $this->render(
            'admin/job/subcategory/new.html.twig',
            array(
                'form' => $form->createView(),
                'vm'   => $vm
            )
        );
    }

    /**
     * Displays a form to edit an existing SubCategory entity.
     *
     * @Route("/{id}/edit", name="manager_job_subcategories_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(SubCategory $Subcategory, Request $request)
    {
        $editForm   = $this->createForm(SubCategoryType::class, $Subcategory);
        $deleteForm = $this->createDeleteForm($Subcategory);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', "the SubCategory has been updated !");

            return $this->redirect($this->generateUrl('manager_job_subcategories'));
        }

        $vm = $this->get('job_view_subcategory_assembler')->create($Subcategory, $action = 'edit');

        return $this->render(
            'admin/job/subcategory/edit.html.twig',
            array(
                'vm'          => $vm,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a SubCategory entity.
     *
     * @Route("/{id}", name="manager_job_subcategories_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param SubCategory $Subcategory
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, SubCategory $Subcategory)
    {
        $form = $this->createDeleteForm($Subcategory);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->remove($Subcategory);
            $em->flush();
        }

        return $this->redirectToRoute('manager_job_subcategories');
    }

    /**
     * Creates a form to delete a SubCategory entity by id.
     *
     * @param SubCategory $Subcategory The SubCategory object
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SubCategory $Subcategory)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('manager_job_subcategories_delete', array('id' => $Subcategory->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
