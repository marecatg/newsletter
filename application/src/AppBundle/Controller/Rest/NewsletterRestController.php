<?php

namespace AppBundle\Controller\Rest;

use AppBundle\Entity\Newsletter;
use FOS\RestBundle\Controller\Annotations\View;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Util\Codes;

class NewsletterRestController extends ParentRestController
{

    /**
     * Recherche les newsletter et leur dernier contenu
     *
     * @ApiDoc(
     * section = "Newsletter",
     *  output={"class"="Newsletter"},
     *  statusCodes={
     *      200="Returned when successful",
     *      404="Returned when user is not found"
     *  }
     * )
     * @View(serializerGroups={"newsletter_list"})
     * @return Response
     */
    public function getAllLastNewsletterAction()
    {

        $orm = $this->getDoctrine();
        $newsletters = $orm->getRepository('AppBundle:Newsletter')->getAllLast();

        return $newsletters;
    }

    /**
     * Recherche une newsletter et son dernier contenu
     *
     * @ApiDoc(
     * section = "Newsletter",
     *  output={"class"="Newsletter"},
     *  statusCodes={
     *      200="Returned when successful",
     *      404="Returned when user is not found"
     *  }
     * )
     * @View(serializerGroups={"newsletter_list"})
     * @param $id integer
     * @return Response
     */
    public function getNewsletterAction($id)
    {

        if ($id == 'null') {
            return $this->view('Id obligatoire', Codes::HTTP_BAD_REQUEST);
        }

        $orm = $this->getDoctrine();
        $newsletters = $orm->getRepository('AppBundle:Newsletter')->getLast($id);

        return $newsletters;
    }

}