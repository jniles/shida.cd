<?php

namespace Koopa\Bundle\JobBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Koopa\Bundle\JobBundle\Entity\Skill;
use Koopa\Bundle\JobBundle\Form\SkillType;

/**
 *
 *
 * @Route("/manager/job/skills")
 */
class SkillController extends Controller
{
    /**
     * index all skills
     *
     * @Route("/", name="manager_job_skills")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em     = $this->getDoctrine()->getManager();
        $skills = $em->getRepository('KoopaJobBundle:Skill')->findAll();
        $vm     = $this->get('job_view_skill_assembler')->createList($skills);

        return $this->render('admin/job/skill/index.html.twig', compact('vm'));
    }

    /**
     * Show a specific skill
     *
     * @Route(
     * "/{id}",
     * name="manager_job_skills_show",
     * requirements={"id"="\d+"}
     * )
     * @Method("GET")
     * @param Skill $skill
     * @return Response
     */
    public function showAction(Skill $skill)
    {
        $deleteForm = $this->createDeleteForm($skill);
        $vm = $this->get('job_view_skill_assembler')->create($skill, $action = 'show');

        return $this->render('admin/job/skill/show.html.twig', array(
            'vm' => $vm,
            'delete_form' => $deleteForm->createView()
        ));
    }

    /**
     * create a new skill
     *
     * @Route("/new", name="manager_job_skills_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $skill = new Skill();
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($skill);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', "the skill has been saved !");

            return $this->redirect($this->generateUrl('manager_job_skills'));
        }

        $vm = $this->get('job_view_skill_assembler')->create($skill);

        return $this->render(
            'admin/job/skill/new.html.twig',
            array(
                'form' => $form->createView(),
                'vm'   => $vm
            )
        );
    }

    /**
     * Displays a form to edit an existing Skill entity.
     *
     * @Route("/{id}/edit", name="manager_job_skills_edit")
     * @Method({"GET", "POST"})
     * @param Skill $skill
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Skill $skill, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $editForm   = $this->createForm(SkillType::class, $skill);
        $deleteForm = $this->createDeleteForm($skill);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', "the skill has been updated !");

            return $this->redirect($this->generateUrl('manager_job_skills'));
        }

        $vm = $this->get('job_view_skill_assembler')->create($skill, $action = 'edit');

        return $this->render(
            'admin/job/skill/edit.html.twig',
            array(
                'vm'          => $vm,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a Skill entity.
     *
     * @Route("/{id}", name="manager_job_skills_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param Skill $skill
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Skill $skill)
    {
        $form = $this->createDeleteForm($skill);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->remove($skill);
            $em->flush();
        }

        return $this->redirectToRoute('manager_job_skills');
    }

    /**
     * Creates a form to delete a Skill entity by id.
     *
     * @param Skill $skill The skill object
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Skill $skill)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('manager_job_skills_delete', array('id' => $skill->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
