<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PendingTag;
use AppBundle\Entity\Tag;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
     * @param id The id of the tag to upvote
     */
    public function voteAction($action, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $tag = $em->getRepository('AppBundle:PendingTag')->find($id);
        if ($tag === null)
            throw $this->createNotFoundException("Tag id ".$id." not found.");

        if ($action == "up")
            $tag->upvote(1);
        else if ($action == "down")
            $tag->downvote(1);

        $em->persist($tag);
        $em->flush();

        return $this->redirect("/home");
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
     */
    public function approveAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $ptag = $em->getRepository('AppBundle:PendingTag')->find($id);

        if ($ptag === null)
            throw $this->createNotFoundException("Tag with id ".$id." not found.");

        $tag = Tag::castFromPending($ptag);

        $em->remove($ptag);
        $em->flush(); // w/o this, doctrine may insert new tag before removing old one, violating unique constraint
        $em->persist($tag);
        $em->flush();

        dump($tag);
        return new Response('Approved');
    }
}
