<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PendingTag;
use AppBundle\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DevController
 * @package AppBundle\Controller
 * @Route("/dev")
 */
class DevController extends Controller
{
    public function checkDevEnv()
    {
        if($this->container->getParameter('kernel.environment'))
            return $this->createNotFoundException();
    }

    /**
     * @Route("/works")
     */
    public function testDevControllerAction()
    {
        return new Response('', 204);
    }

    /**
     * @Route("/reset")
     */
    public function resetTagsAction()
    {
        $this->checkDevEnv();

        $em = $this->getDoctrine()->getManager();
        $tagRepo = $em->getRepository('AppBundle:Tag');
        $ptagRepo = $em->getRepository('AppBundle:PendingTag');


        foreach($tagRepo->findAll() as $tag)
            $em->remove($tag);
        foreach($ptagRepo->findAll() as $ptag)
            $em->remove($ptag);
        $em->flush();

        $tags = array(new Tag("Easy"), new Tag("Hard"), new Tag("Tasty"), new Tag("Traditional"));
        $ptags = array(new PendingTag("Italian"), new PendingTag("Diet"));

        dump($tags);
        dump($ptags);

        foreach ($tags as $tag)
            $em->persist($tag);
        foreach($ptags as $ptag)
            $em->persist($ptag);
        $em->flush();

        return new Response('Done',201);

    }

    /**
     * @Route("/testInheritance")
     */
    public function testInheritanceAction()
    {
        dump($this->getDoctrine()->getRepository('AppBundle:Tag')->findAll());
        return new Response();
    }
}
