<?php

namespace AppBundle\Controller;

use AppBundle\Security\Authorization\UserVoter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     *
     * @Route("/", name="newsletter_angular_js_homepage")
     *
     * Empty controller.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('AppBundle::index.html.twig');
    }
}
