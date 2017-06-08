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

    /**
     *
     * @Route("/testmail", name="test_mail")
     *
     * Empty controller.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function sendEmailAction()
    {
        $message = new \Swift_Message('Hello Email');
            $message->setFrom('send@example.com')
            ->setTo('aubanelm94@gmail.com')
            ->setBody('You should see me from the profiler!')
    ;

    $this->get('mailer')->send($message);

    return $this->render('AppBundle::test/testmail.html.twig');
}
}
