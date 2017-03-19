<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Recipe;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @var request
     */
    public function indexAction(Request $request)
    {
        return $this->render('dashboard.html.twig');
    }

    /**
     * @Route("/home", name="Dashboard")
     */
    public function showDashboard()
    {
        
    }

    /**
     * @Route("/show/{id}", name="Recipe")
     */
    public function showRecipe($id)
    {
        $recipe = $this->getDoctrine()->getRepository('AppBundle:Recipe')->find($id);
        if (!$recipe)
            throw $this->createNotFoundException('This recipe does not exist.');
        return $this->render('_recipe.html.twig',['r'=>$recipe]);
    }

    /**
     * @Route("/create", name="Recipe creation")
     */
    public function createDummyRecipe()
    {
        $em = $this->getDoctrine()->getManager();
        $recipe = new Recipe();
        $recipe->setAuthor("Test author");
        $recipe->setTitle("Test recipe");
        $em->persist($recipe);
        $em->flush();
        return new Response('',201);
    }

    /**
     * @Route("/showAll", name="All recipes")
     */
    public function showAllRecipes()
    {
        $recipes = $this->getDoctrine()->getManager()->getRepository("AppBundle:Recipe")->findAll();
        return $this->render('recipesViewer..html.twig', ['recipes'=>$recipes]);
    }
}
