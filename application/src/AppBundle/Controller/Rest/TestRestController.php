<?php

namespace AppBundle\Controller\Rest;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Util\Codes;

class TestRestController extends ParentRestController
{

    /**
     * Test l'envoi de mail
     *
     * @ApiDoc(
     * section = "Test",
     *  output={"class"="Response"},
     *  statusCodes={
     *      200="Returned when successful",
     *      500="Returned when error occured"
     *  }
     * )
     *
     * @param $to
     * @return Response
     */
    public function getTestEmailAction($to)
    {

        $message = \Swift_Message::newInstance()
            ->setSubject('Hello World')
            ->setFrom($this->container->getParameter("mailer_user"))
            ->setTo($to)
            ->setBody(
                $this->renderView('@AppBundle/Resources/views/email/test.html.twig'
                ),
                'text/html'
            )
        ;
        $this->get('mailer')->send($message);

        return $this->view("Envoyé", Codes::HTTP_OK);
    }

}