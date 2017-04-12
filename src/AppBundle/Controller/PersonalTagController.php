<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PersonalTag;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Personaltag controller.
 *
 * @Route("personaltag")
 */
class PersonalTagController extends Controller
{
    /**
     * Lists all personalTag entities.
     *
     * @Route("/", name="personaltag_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $personalTags = $em->getRepository('AppBundle:PersonalTag')->findBy(['owner'=>$this->getUser()]);

        return $this->render('personaltag/index.html.twig', array(
            'personalTags' => $personalTags,
        ));
    }

    /**
     * Creates a new personalTag entity.
     *
     * @Route("/new", name="personaltag_new")
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

            return $this->redirectToRoute('personaltag_show', array('id' => $personalTag->getId()));
        }

        return $this->render('personaltag/new.html.twig', array(
            'personalTag' => $personalTag,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a personalTag entity.
     *
     * @Route("/{id}", name="personaltag_show")
     * @Method("GET")
     */
    public function showAction(PersonalTag $personalTag)
    {
    	if($personalTag->getOwner() != $this->getUser())
    		throw new NotFoundHttpException();

        $deleteForm = $this->createDeleteForm($personalTag);

        return $this->render('personaltag/show.html.twig', array(
            'personalTag' => $personalTag,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing personalTag entity.
     *
     * @Route("/{id}/edit", name="personaltag_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, PersonalTag $personalTag)
    {
	    if($personalTag->getOwner() != $this->getUser())
		    throw new NotFoundHttpException();

        $deleteForm = $this->createDeleteForm($personalTag);
        $editForm = $this->createForm('AppBundle\Form\PersonalTagType', $personalTag);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('personaltag_edit', array('id' => $personalTag->getId()));
        }

        return $this->render('personaltag/edit.html.twig', array(
            'personalTag' => $personalTag,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a personalTag entity.
     *
     * @Route("/{id}", name="personaltag_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, PersonalTag $personalTag)
    {
	    if($personalTag->getOwner() != $this->getUser())
		    throw new NotFoundHttpException();

        $form = $this->createDeleteForm($personalTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($personalTag);
            $em->flush();
        }

        return $this->redirectToRoute('personaltag_index');
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
            ->setAction($this->generateUrl('personaltag_delete', array('id' => $personalTag->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
