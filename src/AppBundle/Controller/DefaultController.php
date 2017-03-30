<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Recipe;
use Doctrine\ORM\QueryBuilder;
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
        return $this->redirect('/home');
    }

    /**
     * @Route("/home", name="dashboard")
     */
    public function showDashboard()
    {
        dump($this->getUser());
        $em = $this->getDoctrine()->getManager();


        // 5 most recent recipes (order by creation date, 5 max)
        $q = $em->createQueryBuilder()
        ->select('r')
        ->from('AppBundle:Recipe','r')
        ->orderby('r.creationDate','DESC')
        ->orWhere('r.public = true')
        ->setMaxResults(5);

        $recipes = $q->getQuery()->getResult();

        $tags = $em->createQueryBuilder()
            ->select('t')
            ->from('AppBundle:Tag','t')
            ->getQuery()->getResult()
        ;

        $pendingTags = $em->createQueryBuilder()
            ->select('pt')
            ->from('AppBundle:PendingTag','pt')
            ->getQuery()->getResult()
        ;

        $collections = $em->createQueryBuilder()
            ->select('c')
            ->from('AppBundle:Collection', 'c')
            ->setmaxResults(3)
            ->getQuery()->getResult()
        ;

        return $this->render('dashboard.html.twig',
            [
                "latest_recipes"=>$recipes,
                "tags"=>$tags,
                "tags_pending"=>$pendingTags,
                "collections"=>$collections,
            ]
        );
    }

}
