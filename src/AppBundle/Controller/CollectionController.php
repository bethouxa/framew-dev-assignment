<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Collection;
use AppBundle\Form\SimpleSearchType;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Collection controller.
 *
 * @Route("collection")
 */
class CollectionController extends Controller
{
    /**
     * Lists all collection entities.
     *
     * @Route("/", name="collection_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $incl_private = $request->get("incl_private", false);

	    //FIXME
	    $searchString = new SimpleSearchType();
	    $searchForm = $this->createFormBuilder($searchString)
		    ->add("searchTerms", TextType::class, ['required'=>true])
		    ->add("Search", SubmitType::class)
		    ->getForm();
	    $searchForm->handleRequest($request);

	    $qb = $em->createQueryBuilder();
	    $q = $qb
		    ->select('c')
		    ->from('AppBundle:Collection', 'c');

	    if ($searchForm->isSubmitted() && $searchForm->isValid())
	    {
		    $q->andwhere($qb->expr()->like('c.name','?1'));
		    $q->setParameter(1, $searchString->getSearchTerms());
	    }

        if ($incl_private)
        {
            $this->denyAccessUnlessGranted('ROLE_ADMIN',null, "Forbidden: only admins can list non-shared collections.");;
        }
        else
        {
	        $q->andwhere($qb->expr()->eq('c.shared', true));
        }

        return $this->render('collection/index.html.twig', array(
            'collections' => $q->getQuery()->getResult(),
	        'search_form' => $searchForm->createView(),
        ));
    }

    /**
     * Creates a new collection entity.
     *
     * @Route("/new", name="collection_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
     */
    public function newAction(Request $request)
    {
        $collection = new Collection($this->getUser());
        $form = $this->createForm('AppBundle\Form\CollectionType', $collection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($collection);
            $em->flush();

            return $this->redirectToRoute('collection_show', array('id' => $collection->getId()));
        }

        return $this->render('collection/new.html.twig', array(
            'collection' => $collection,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a collection entity.
     *
     * @Route("/{id}", name="collection_show")
     * @Method("GET")
     */
    public function showAction(Collection $collection)
    {
        $deleteForm = $this->createDeleteForm($collection);

        return $this->render('collection/show.html.twig', array(
            'collection' => $collection,
            'delete_form' => $deleteForm->createView(),
        ));
    }



    /**
     * Displays a form to edit an existing collection entity.
     *
     * @Route("/{id}/edit", name="collection_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Collection $collection)
    {
        $deleteForm = $this->createDeleteForm($collection);
        $editForm = $this->createForm('AppBundle\Form\CollectionType', $collection);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('collection_edit', array('id' => $collection->getId()));
        }

        return $this->render('collection/edit.html.twig', array(
            'collection' => $collection,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a collection entity.
     *
     * @Route("/{id}", name="collection_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Collection $collection)
    {
        $form = $this->createDeleteForm($collection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($collection);
            $em->flush();
        }

        return $this->redirectToRoute('collection_index');
    }

    /**
     * Creates a form to delete a collection entity.
     *
     * @param Collection $collection The collection entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Collection $collection)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('collection_delete', array('id' => $collection->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
