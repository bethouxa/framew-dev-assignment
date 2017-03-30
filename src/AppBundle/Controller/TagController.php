<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PendingTag;
use AppBundle\Entity\Tag;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class TagController
 * @package AppBundle\Controller
 * @Route("/tag")
 */
class TagController extends Controller
{
    /**
     * @Route("/vote/{action}/{id}", name="vote_tag")
     * @param id String The id of the tag to upvote
     * @param action String 'up' or 'down"
     */
    public function voteAction(Request $r, String $action, String $id)
    {

        $tag = $this->getDoctrine()->getRepository('AppBundle:PendingTag')->find((int)$id);
        if ($tag === null)
            throw $this->createNotFoundException("Tag id ".$id." not found.");

        if($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED'))
            $this->voteUser($action, $tag);
        else
            $this->voteAnon($action, $tag, $r);

        return $this->redirect("/home");
    }

    public function voteUser(String $action, PendingTag $tag)
    {
        $user = $this->getUser();

        if (in_array($tag, $user->getTagsUpvoted()->toArray(), true))
        {
            $tag->downvote(5);
            $user->removeTagsUpvoted($tag);
        }
        else if(in_array($tag, $user->getTagsDownvoted()->toArray(), true))
        {
            $tag->upvote(5);
            $user->removeTagsDownvoted($tag);
        }

        if ($action == "up")
        {
            $tag->upvote(5);
            $user->addTagsUpvoted($tag);
        }
        else if ($action == "down")
        {
            $tag->downvote(5);
            $user->addTagsDownvoted($tag);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($tag);
        $em->flush();
    }

    //TODO: implement cookie check
    public function voteAnon(String $action, PendingTag $tag, Request $r)
    {
        if ($action == "up")
            $tag->upvote(1);
        else if ($action == "down")
            $tag->downvote(1);

        $em = $this->getDoctrine()->getManager();
        $em->persist($tag);
        $em->flush();
    }

    /**
     * @Route("/new", name="submit_tag")
     */
    public function newTagAction(Request $r)
    {
        $tag = new PendingTag("");

        $form = $this->createFormBuilder($tag)
            ->add('name', TextType::class)
            ->add('Submit', SubmitType::class, array('label' => 'Submit tag'))
            ->getForm();

        $form->handleRequest($r);

        if ($form->isSubmitted() && $form->isValid()) {
            $tag = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($tag);
            try {
                $em->flush();
            } catch (UniqueConstraintViolationException $pdo) {
                return new Response('Tag already exists', 422);
            }
            //FIXME
            return new Response('Created',201);
        }

        return $this->render(':tag:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/approve/{id}")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function approveAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $ptag = $em->getRepository('AppBundle:PendingTag')->find($id);

        if ($ptag === null)
            throw $this->createNotFoundException("Tag with id ".$id." not found.");

        $tag = new Tag($ptag);

        $em->remove($ptag);
        $em->flush(); // w/o this, doctrine may insert new tag before removing old one, violating unique constraint
        $em->persist($tag);
        $em->flush();

        dump($tag);
        return new Response('Approved');
    }
}
