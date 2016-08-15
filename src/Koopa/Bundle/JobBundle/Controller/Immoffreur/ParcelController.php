<?php


namespace Koopa\Bundle\JobBundle\Controller\Immoffreur;


use Koopa\Bundle\JobBundle\Form\ParcelType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Koopa\Bundle\JobBundle\Entity\Parcel;
use Koopa\Bundle\JobBundle\Entity\Address;

/**
 * Class ParcelController
 * @Route("/immoffreur/parcels")
 */
class ParcelController extends Controller
{
    /**
     * @Route("/", name="immoffreur_parcels_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getId();
        $parcels = $em->getRepository('KoopaJobBundle:Parcel')->fetchAllByUser($userId);

        $vm = new \stdClass();
        $vm->pageTitle = 'Liste parcelles';

        return $this->render('immoffreur/parcel/index.html.twig', compact('vm', 'parcels'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     * @Route("/new", name="immoffreur_parcels_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $parcel = new Parcel();
        $parcel->setAuthor($this->getUser());
        $form = $this->createForm(ParcelType::class, $parcel);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($parcel);
            $em->flush();

            $this->addFlash('success', "Parcel has been created !");

            return $this->redirectToRoute('immoffreur_parcels_index');
        }

        $vm = new \stdClass();
        $vm->pageTitle = 'Parcelle';

        return $this->render('immoffreur/parcel/new.html.twig', array(
            'vm' => $vm,
            'form' => $form->createView(),
            'parcel' => $parcel
        ));
    }


    /**
     * @param Parcel $parcel
     * @return Response
     * @Route("/{id}", name="immoffreur_parcels_show", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function showAction(Parcel $parcel)
    {
        $vm = new \stdClass();
        $vm->pageTitle = 'Parcelle';
        $deleteForm = $this->createDeleteForm($parcel);

        return $this->render('immoffreur/parcel/show.html.twig', array(
            'vm' => $vm,
            'delete_form' => $deleteForm->createView(),
            'parcel' => $parcel
        ));
    }

    /**
     * @param Request $request
     * @param Parcel $parcel
     * @return RedirectResponse|Response
     * @Route("/{id}/edit", name="immoffreur_parcels_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Parcel $parcel)
    {
        $editForm = $this->createForm(ParcelType::class, $parcel);
        $deleteForm = $this->createDeleteForm($parcel);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Parcel has been updated.');

            return $this->redirectToRoute('immoffreur_parcels_show', array('id' => $parcel->getId()));
        }

        $vm = new \stdClass();
        $vm->pageTitle = 'Parcelle';

        return $this->render('immoffreur/parcel/edit.html.twig', array(
            'form' => $editForm->createView(),
            'vm' => $vm,
            'delete_form' => $deleteForm->createView(),
            'parcel' => $parcel
        ));
    }

    /**
     * @param Request $request
     * @Route("/{id}", name="immoffreur_parcels_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     * @param Parcel $parcel
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Parcel $parcel)
    {
        $form = $this->createDeleteForm($parcel);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($parcel);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Parcel has been deleted.');

            return $this->redirectToRoute('immoffreur_parcels_index');
        }
    }

    /**
     * @param Parcel $parcel
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm(Parcel $parcel)
    {
        return $this->createFormBuilder()
            ->setMethod('DELETE')
            ->setAction($this->generateUrl('immoffreur_parcels_delete', array('id' => $parcel->getId())))
            ->getForm();
    }
}
