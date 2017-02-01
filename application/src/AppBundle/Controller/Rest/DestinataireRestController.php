<?php

namespace AppBundle\Controller\Rest;

use FOS\RestBundle\Controller\Annotations\View;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DestinataireRestController extends ParentRestController
{

    /**
     * Recherche un destinataire
     *
     * @ApiDoc(
     * section = "Destinataire",
     *  output={"class"="Destinataire"},
     *  statusCodes={
     *      200="Returned when successful",
     *      404="Returned when user is not found"
     *  }
     * )
     *
     * @param $id integer
     * @return Response
     */
    public function getDestinataireAction($id)
    {

        $orm = $this->getDoctrine();
        $destinataire = $orm->getRepository('AppBundle:Destinataire')->find($id);

        return $this->returnObject($destinataire);
    }
}