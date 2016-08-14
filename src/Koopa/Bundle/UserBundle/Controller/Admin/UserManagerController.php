<?php

namespace Koopa\Bundle\UserBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Koopa\Bundle\UserBundle\Entity\User;

/**
 * @Route("/admin/users")
 */
class UserManagerController extends Controller
{
    /**
     * @Route("/", name="admin_usermanagers")
     * @Method("GET")
     */
    public function indexAction()
    {
        $users = $this->get('fos_user.user_manager')->findUsers();
        $vm = $this->get('user_view_user_assembler')->createList($users);

        return $this->render('admin/usermanager/index.html.twig', compact('vm'));
    }

    /**
     * @Route("/{id}/edit", name="admin_usermanagers_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, User $user)
    {
        $existingRoles = $this->get('koopa_app.role_provider')->getExistingRoles($all = false);
        $form = $this
            ->createFormBuilder()
            ->add('roles', ChoiceType::class, array(
                'choices' => $existingRoles->toArray(),
                'data' => $user->getRoles(),
                'label' => 'Roles',
                'expanded' => false,
                'multiple' => true,
                'mapped' => true,
            ))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $roles = $form->getData();
            $roles = $roles['roles'];
            $user->setRoles(array_values($roles));

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'User has been updated');

            return $this->redirectToRoute('admin_usermanagers_show', array('id' => $user->getId()));
        }

        $vm = $this->get('user_view_user_assembler')->create($user, 'edit');

        return $this->render('admin/usermanager/edit.html.twig', array(
            'form' => $form->createView(),
            'vm' => $vm
        ));
    }

    /**
     * @Route(
     * "/{id}",
     * name="admin_usermanagers_show",
     * requirements={
     * "id"="\d+"
     * }
     * )
     * @Method("GET")
     * @param User $user
     * @return Response
     */
    public function showAction(User $user)
    {
        $vm = $this->get('user_view_user_assembler')->create($user, $action = 'show', $leftJoin = true);

        return $this->render('admin/usermanager/show.html.twig', compact('vm'));
    }

    /**
     * @Route(
     * "/{role}",
     * name="admin_usermanagers_list",
     * requirements={
     * "role"="(advertiser|applicant|manager|admin)"
     * }
     * )
     * @Method("GET")
     * @param string $role
     * @return Response
     */
    public function listAction($role)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('KoopaUserBundle:User')->fetchByRole($role);

        $vm = $this->get('user_view_user_assembler')->createList($users);

        return $this->render('admin/usermanager/'.$role.'.html.twig', compact('vm'));
    }
}
