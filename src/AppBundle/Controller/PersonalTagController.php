<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PersonalTag;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Personaltag controller.
 *
 * @Route("ptag")
 */
class PersonalTagController extends Controller
{
    /**
     * Creates a new personalTag entity.
     *
     * @Route("/new", name="ptag_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $personalTag = new Personaltag("", $this->getUser());
        $form = $this->createForm('AppBundle\Form\PersonalTagType', $personalTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($personalTag);
            $em->flush($personalTag);

            return $this->redirectToRoute('ptag_show', array('id' => $personalTag->getId()));
        }

        return $this->render('personaltag/new.html.twig', array(
            'personalTag' => $personalTag,
            'form' => $form->createView(),
        ));
    }

    /**
     * Deletes a personalTag entity.
     *
     * @Route("/{id}", name="ptag_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, PersonalTag $personalTag)
    {
        $form = $this->createDeleteForm($personalTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($personalTag);
            $em->flush();
        }

        return $this->redirectToRoute('ptag_index');
    }

    /**
     * Creates a form to delete a personalTag entity.
     *
     * @param PersonalTag $personalTag The personalTag entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PersonalTag $personalTag)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ptag_delete', array('id' => $personalTag->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
