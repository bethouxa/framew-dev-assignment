<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Recipe;
use AppBundle\Form\SimpleSearchType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Recipe controller.
 *
 * @Route("recipe")
 */
class RecipeController extends Controller
{
    /**
     * Lists all recipe entities.
     *
     * @Route("/", name="recipe_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $incl_private = $request->query->get('incl_private', false);

        //FIXME
        $searchString = new SimpleSearchType();
	    $searchForm = $this->createFormBuilder($searchString)
        ->add("searchTerms", TextType::class, ['required'=>true])
        ->getForm();
        $searchForm->handleRequest($request);

	    $qb = $em->createQueryBuilder();
	    $q = $qb
		    ->select('r')
		    ->from('AppBundle:Recipe', 'r');

        if ($searchForm->isSubmitted() && $searchForm->isValid())
        {
	        $q->andwhere($qb->expr()->orX(
	            $qb->expr()->like('r.title','?1'),
		        $qb->expr()->like('r.summary', '?1')
	        ))
	        ->setParameter(1, $searchString->getSearchTerms());
        }
        if ($incl_private)
        {
            $this->denyAccessUnlessGranted('ROLE_ADMIN', null, "Forbidden: Only admins can list non public recipes.");
        }
        else
        {
        	$q->andwhere($qb->expr()->eq('r.public', true));
        }

        $recipes = $q->getQuery()->getResult();
        return $this->render('recipe/index.html.twig', ['recipes' => $recipes, 'search_form' => $searchForm->createView()]);
    }

    /**
     * Creates a new recipe entity.
     *
     * @Route("/new", name="recipe_new")
     * @Method({"GET", "POST"})
     * TODO: logged in users only
     */
    public function newAction(Request $request)
    {
        $recipe = new Recipe();
        $recipe->setAuthor($this->getUser());
        $form = $this->createForm('AppBundle\Form\RecipeType', $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($recipe);
            $em->flush();

            return $this->redirectToRoute('recipe_show', array('id' => $recipe->getId()));
        }

        return $this->render('recipe/new.html.twig', array(
            'recipe' => $recipe,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a recipe entity.
     *
     * @Route("/{id}", name="recipe_show")
     * @Method("GET")
     */
    public function showAction(Recipe $recipe)
    {
        $deleteForm = $this->createDeleteForm($recipe);
        return $this->render('recipe/show.html.twig', ['recipe' => $recipe, 'delete_form' => $deleteForm->createView()]);
    }

    /**
     * Displays a form to edit an existing recipe entity.
     *
     * @Route("/{id}/edit", name="recipe_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Recipe $recipe)
    {
        $deleteForm = $this->createDeleteForm($recipe);
        $editForm = $this->createForm('AppBundle\Form\RecipeType', $recipe);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('recipe_edit', array('id' => $recipe->getId()));
        }

        return $this->render('recipe/edit.html.twig', array(
            'recipe' => $recipe,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a recipe entity.
     *
     * @Route("/{id}", name="recipe_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Recipe $recipe)
    {
        $form = $this->createDeleteForm($recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($recipe);
            $em->flush();
        }

        return $this->redirectToRoute('recipe_index');
    }

    /**
     * Creates a form to delete a recipe entity.
     *
     * @param Recipe $recipe The recipe entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Recipe $recipe)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('recipe_delete', array('id' => $recipe->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function getLatestPublicRecipes($amt) {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        $q = $qb->select('r')
            ->from('Recipe')
            ->where('Recipe.public = true')
            ->orderby('u.creationdate','DESC')
            ->setMaxResults($amt)
            ->getQuery();

        return $q->getResult();
    }

    /**
     * @return FormInterface
     */
    public function getSearchForm()
    {
        $form = $this->createFormBuilder()
            ->add('Name', TextType::class)
            ->add('search', SubmitType::class, ['label'=>"Search"])
            ->getForm();

        return $form;
    }
}
