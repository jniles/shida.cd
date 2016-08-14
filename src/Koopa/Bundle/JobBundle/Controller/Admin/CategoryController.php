<?php

namespace Koopa\Bundle\JobBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Koopa\Bundle\JobBundle\Entity\Category;
use Koopa\Bundle\JobBundle\Form\CategoryType;

/**
 *
 *
 * @Route("/manager/job/categories")
 */
class CategoryController extends Controller
{
    /**
     * index all Category
     *
     * @Route("/", name="manager_job_categories")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('KoopaJobBundle:Category')->findAll();
        $vm = $this->get('job_view_category_assembler')->createList($categories);

        return $this->render('admin/job/category/index.html.twig', compact('vm'));
    }

    /**
     * show a category
     *
     * @Route(
     * "/{id}",
     * name="manager_job_categories_show",
     * requirements={
     * "id"="\d+"
     * }
     * )
     * @Method("GET")
     * @param Category $category
     * @return Response
     */
    public function showAction(Category $category)
    {
        $vm = $this->get('job_view_category_assembler')->create($category, 'show');
        $deleteForm = $this->createDeleteForm($category);

        return $this->render('admin/job/category/show.html.twig', array(
            'vm' => $vm,
            'delete_form' => $deleteForm->createView()
        ));
    }


    /**
     * create a new Category
     *
     * @Route("/new", name="manager_job_categories_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', "the Category has been saved !");

            return $this->redirect($this->generateUrl('manager_job_categories'));
        }

        $vm = $this->get('job_view_category_assembler')->create($category);

        return $this->render(
            'admin/job/category/new.html.twig',
            array(
                'form' => $form->createView(),
                'vm'   => $vm
            )
        );
    }

    /**
     * Displays a form to edit an existing Category entity.
     *
     * @Route("/{id}/edit", name="manager_job_categories_edit")
     * @Method({"GET", "POST"})
     * @param Category $category
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Category $category, Request $request)
    {
        $editForm   = $this->createForm(CategoryType::class, $category);
        $deleteForm = $this->createDeleteForm($category);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', "the Category has been updated !");

            return $this->redirect($this->generateUrl('manager_job_categories'));
        }

        $vm = $this->get('job_view_category_assembler')->create($category, $action = 'edit');

        return $this->render(
            'admin/job/category/edit.html.twig',
            array(
                'vm'          => $vm,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a Category entity.
     *
     * @Route("/{id}", name="manager_job_categories_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Category $category)
    {
        $form = $this->createDeleteForm($category);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->remove($category);
            $em->flush();
        }

        return $this->redirectToRoute('manager_job_categories');
    }

    /**
     * Creates a form to delete a Category entity by id.
     *
     * @param Category $category The Category object
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Category $category)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('manager_job_categories_delete', array('id' => $category->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
