<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->redirect('/home');
    }

    /**
     * @Route("/home", name="dashboard")
     */
    public function showDashboardAction()
    {
        $em = $this->getDoctrine()->getManager();


        // 5 most recent recipes (order by creation date, 5 max)
        $pub_recipes = $em->createQueryBuilder()
            ->select('r')
            ->from('AppBundle:Recipe','r')
            ->orderby('r.creationDate','DESC')
            ->orWhere('r.public = true')
            ->setMaxResults(5)
            ->getQuery()->getResult()
        ;

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

        $pub_collections = $em->createQueryBuilder()
            ->select('c')
            ->from('AppBundle:Collection', 'c')
            ->where('c.shared = true')
            ->setmaxResults(3)
            ->getQuery()->getResult()
        ;

        return $this->render('dashboard.html.twig',
            [
                "latest_recipes"=>$pub_recipes,
                "tags"=>$tags,
                "tags_pending"=>$pendingTags,
                "collections"=>$pub_collections,
            ]
        );
    }

    /**
     * @Route("/userpanel", name="user_panel")
     */
    public function showUserPanelAction()
    {
        dump($this->getUser()->getPersonalTags());
        return $this->render('::user_panel.html.twig', ['user'=>$this->getUser()]);
    }

}
