<?php

namespace AppBundle\DevController;

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
    /**
     * @Route("/works")
     */
    public function testDevControllerAction()
    {
        return new Response(null,204);
    }

    /**
     * @Route("/reset")
     */
    public function resetTagsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $tagRepo = $em->getRepository('AppBundle:Tag');
        $ptagRepo = $em->getRepository('AppBundle:PendingTag');


        foreach($tagRepo->findAll() as $tag)
            $em->remove($tag);
        foreach($ptagRepo->findAll() as $ptag)
            $em->remove($ptag);
        $em->flush();

        $tags = [
            new Tag(new PendingTag("Easy")),
            new Tag(new PendingTag("Hard")),
            new Tag(new PendingTag("Tasty")),
            new Tag(new PendingTag("Traditional"))
        ];

        $ptags = [
            new PendingTag("Italian"),
            new PendingTag("Diet")
        ];

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
        return $this->render('empty.html.twig');
    }

    /**
     * @Route("/roles")
     */
    public function displRolesAction() {
        dump($this->getUser()->getRoles());
        return $this->render('empty.html.twig');
    }

    /**
     * @Route("/grant")
     */
    public function grantRolesAction() {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED'))
            throw $this->createAccessDeniedException();

        $u = $this->getUser()->setSuperAdmin(true);
        $this->getDoctrine()->getManager()->persist($u);
        $this->getDoctrine()->getManager()->flush();

        return $this->render("empty.html.twig");
    }

    /**
     * @Route("/test")
     */
    public function miscTestAction()
    {
        $recipe = $this->getDoctrine()->getManager()->getRepository('AppBundle:Recipe')->find(1);
        foreach ($recipe->getTags() as $tag)
            dump($tag);
        return $this->render('empty.html.twig');
    }

    /**
     * @Route("/findNothing")
     */
    public function findNothingAction() {
        $nothing = $this->getDoctrine()->getManager()->getRepository('AppBundle:Recipe')->find(450);
        dump($nothing);
        return $this->render('empty.html.twig');
    }
}
