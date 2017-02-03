<?php

namespace AppBundle\Controller\Rest;

use AppBundle\Entity\Destinataire;
use FOS\RestBundle\Controller\Annotations\View;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Util\Codes;

class ListeDiffusionRestController extends ParentRestController
{

    /**
     * Recherche toutes les liste de diffusion
     *
     * @ApiDoc(
     * section = "Destinataire",
     *  output={"class"="Destinataire"},
     *  statusCodes={
     *      200="Returned when successful",
     *      404="Returned when user is not found"
     *  }
     * )
     * @View(serializerGroups={"liste_info"})
     *
     * @return Response
     */
    public function getAllListesDiffusionAction()
    {

        $orm = $this->getDoctrine();
        $listes = $orm->getRepository('AppBundle:ListeDiffusion')->findAll();

//        if ($destinataire == null) {
//            return $this->view('Destinaiatre non trouvé avec l\'id '.$id, Codes::HTTP_NOT_FOUND);
//        }

        return $listes;
    }
}