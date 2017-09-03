<?php

namespace LandingBundle\Controller;

use BaseBundle\Entity\Contact;
use BaseBundle\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $projets = $em->getRepository('BaseBundle:Projet')->findAll();
        $features = $em->getRepository('BaseBundle:Feature')->findAll();

        $main_value = $em->getRepository('BaseBundle:Texte')->findOneBy(
            array("intitule" => "main_page_value")
        );

        $title_feat = $em->getRepository("BaseBundle:Texte")->findOneBy(
            array("intitule" => "main_page_feat_title")
        );

        $title_contact = $em->getRepository("BaseBundle:Texte")->findOneBy(
            array("intitule" => "main_page_contact_title")
        );

        $undertitle_contact = $em->getRepository("BaseBundle:Texte")->findOneBy(
            array("intitule" => "main_page_contact_undertitle")
        );

        $title_portfolio = $em->getRepository("BaseBundle:Texte")->findOneBy(
            array("intitule" => "main_page_portfolio_title")
        );

        $contact = new Contact;

        $form = $this->get('form.factory')->create(ContactType::class, $contact);

        return $this->render('LandingBundle:Landing:main.html.twig', array(
            "projets" => $projets,
            "features" => $features,
            "form" => $form->createView(),
            "mainValue" => $main_value,
            "mainFeatTitle" => $title_feat,
            "mainContactTitle" => $title_contact,
            "mainContactUndertitle" => $undertitle_contact,
            "mainPortfolioTitle" => $title_portfolio,
        ));
    }
}
