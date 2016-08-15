<?php


namespace Koopa\Bundle\JobBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Koopa\Bundle\JobBundle\Entity\Parcel;

/**
 * @Route("/p")
 */
class OffreController extends Controller
{
    /**
     * @param Parcel $parcel
     * @return Response
     * @Route("/{id}", name="p_show", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function showAction(Parcel $parcel)
    {
        $vm = new \stdClass();
        $vm->pageTitle = 'Parcelle';

        return $this->render('parcel/show.html.twig', array(
            'vm' => $vm,
            'parcel' => $parcel
        ));
    }
}
