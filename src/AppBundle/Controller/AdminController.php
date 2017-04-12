<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\BrowserKit\Response;

/**
 * Class AdminController
 * @package AppBundle\Controller
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction() {
        return new Response("Tworks!");
    }

    /**
     * @Route("/users")
     */
    public function userManagementAction()
    {
        return $this->render('AppBundle:Admin:user_management.html.twig', array());
    }

}
