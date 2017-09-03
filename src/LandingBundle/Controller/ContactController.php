<?php

namespace LandingBundle\Controller;



use BaseBundle\Entity\Contact;
use BaseBundle\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 * Contact controller.
 *
 * @Route("contact")
 */
class ContactController extends Controller
{

    /**
     * Lists all contact entities.
     *
     * @Route("/add", name="user_contact_add")
     */
    public function addAction(Request $request){
        $contact = new Contact();

        $form = $this->get('form.factory')->create(ContactType::class, $contact);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();

            $em->persist($contact);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Contact bien enregistré');

            return $this->redirectToRoute('landing_default_index');
        }
    }
}
