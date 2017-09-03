<?php

namespace BaseBundle\Controller;

use BaseBundle\Entity\Feature;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Feature controller.
 *
 * @Route("admin/feature")
 */
class FeatureController extends Controller
{
    /**
     * Lists all feature entities.
     *
     * @Route("/", name="admin_feature_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $features = $em->getRepository('BaseBundle:Feature')->findAll();

        return $this->render('AdminBundle:feature:index.html.twig', array(
            'features' => $features,
        ));
    }

    /**
     * Creates a new feature entity.
     *
     * @Route("/new", name="admin_feature_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $feature = new Feature();
        $form = $this->createForm('BaseBundle\Form\FeatureType', $feature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($feature);
            $em->flush();

            return $this->redirectToRoute('admin_feature_show', array('id' => $feature->getId()));
        }

        return $this->render('AdminBundle:feature:new.html.twig', array(
            'feature' => $feature,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a feature entity.
     *
     * @Route("/{id}", name="admin_feature_show")
     * @Method("GET")
     */
    public function showAction(Feature $feature)
    {
        $deleteForm = $this->createDeleteForm($feature);

        return $this->render('AdminBundle:feature:show.html.twig', array(
            'feature' => $feature,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing feature entity.
     *
     * @Route("/{id}/edit", name="admin_feature_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Feature $feature)
    {
        $deleteForm = $this->createDeleteForm($feature);
        $editForm = $this->createForm('BaseBundle\Form\FeatureType', $feature);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_feature_edit', array('id' => $feature->getId()));
        }

        return $this->render('AdminBundle:feature:edit.html.twig', array(
            'feature' => $feature,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a feature entity.
     *
     * @Route("/{id}", name="admin_feature_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Feature $feature)
    {
        $form = $this->createDeleteForm($feature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($feature);
            $em->flush();
        }

        return $this->redirectToRoute('admin_feature_index');
    }

    /**
     * Creates a form to delete a feature entity.
     *
     * @param Feature $feature The feature entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Feature $feature)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_feature_delete', array('id' => $feature->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
