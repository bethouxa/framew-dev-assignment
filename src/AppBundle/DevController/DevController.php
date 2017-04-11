<?php

namespace AppBundle\DevController;

use AppBundle\Entity\PendingTag;
use AppBundle\Entity\PersonalTag;
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
     * @Route("/dumpuser")
     */
    public function dumpUser()
    {
        dump($this->getUser());
        return $this->render("::empty.html.twig");
    }

    /**
     * @Route("/resetTags")
     */
    public function resetTagsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $tagRepo = $em->getRepository('AppBundle:Tag');
        $ptagRepo = $em->getRepository('AppBundle:PendingTag');

        foreach($tagRepo->findAll() as $tag)
        {
	        $em->remove($tag);
	        foreach ($em->getRepository('AppBundle:Recipe')->findAll() as $recipe)
		        $recipe->removeTag($tag);
        }
        foreach($ptagRepo->findAll() as $ptag)
        {
	        $em->remove($ptag);
	        foreach ($em->getRepository('AppBundle:Recipe')->findAll() as $recipe)
		        $recipe->removeTag($ptag);
        }
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

	    $testUser = $this->getDoctrine()->getRepository('AppBundle:User')->findBy(["username"=>'test']);

	    $persoTags = [
        	new PersonalTag("testPerso1", $testUser),
        	new PersonalTag("testPerso2", $testUser),
        ];



        foreach ($tags as $tag)
            $em->persist($tag);
        foreach($ptags as $ptag)
            $em->persist($ptag);
        foreach ($persoTags as $perTag)
        	$em->persist($perTag);
        $em->flush();

        return $this->render('::short_message.html.twig', ["message"=>"Done."]);

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
    	$em = $this->getDoctrine()->getManager();
    	$t = new PersonalTag("Test perso 1", $this->getUser());
    	$em->persist($t);
    	$em->flush();
    	return $this->render('short_message.html.twig', ['message'=>"done"]);
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
