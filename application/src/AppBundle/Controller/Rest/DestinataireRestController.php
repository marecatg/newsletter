<?php

namespace AppBundle\Controller\Rest;

use FOS\RestBundle\Controller\Annotations\View;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Config\Definition\Exception\Exception;
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

    /**
     * Creer un destinataire
     *
     * @ApiDoc(
     * section = "Destinataire",
     *  output={"class"="Response"},
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Est retourné lorsque le destinataire est invalide"
     *  }
     * )
     *
     * @param $request Request
     * @return Response
     */
    public function postDestinataireAction($request)
    {

        $params = array();
        if (!empty($request->getContent()))
        {
            $params = json_decode($request->getContent(), true); // 2nd param to get as array
        }

        $destinataire = null;

        if (isset($params['nom']) && $params['nom'] != null) {
            $destinataire['nom'] = $params['nom'];
        }

        if (isset($params['prenom']) && $params['prenom'] != null) {
            $destinataire['prenom'] = $params['prenom'];
        }

        if (isset($params['email']) && $params['email'] != null) {
            $destinataire['email'] = $params['email'];
        }

        return $this->processForm($destinataire);
    }
}