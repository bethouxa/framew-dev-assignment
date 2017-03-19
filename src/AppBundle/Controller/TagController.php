<?php

namespace AppBundle\Controller;

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
     * @Route("/up/{id}", name="upvote_tag")
     * @param id The id of the tag to upvote
     */
    public function upvoteAction($id)
    {
        $tag = $this->getDoctrine()->getRepository('AppBundle:Tag')->find($id);
        $tag->upvote(1);
        return $this->redirect("dashboard");
    }

    /**
     * @Route("/down/{id}", name="downvote_tag")
     * @param id the id of the tag to upvote
     */
    public function downvoteAction($id)
    {
        $tag = $this->getDoctrine()->getRepository('AppBundle:Tag')->find($id);
        $tag->downvote(1);
        return $this->redirect("dashboard");
    }

    /**
     * @Route("/new", name="submit_tag")
     */
    public function newTagAction(Request $r)
    {
        $tag = new Tag();

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
}
