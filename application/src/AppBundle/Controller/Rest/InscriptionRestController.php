<?php
/**
 * Created by PhpStorm.
 * User: Gaetan
 * Date: 12/06/2017
 * Time: 19:56
 */

namespace AppBundle\Controller\Rest;

use FOS\RestBundle\Controller\Annotations\View;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Util\Codes;


class InscriptionRestController extends ParentRestController
{

    /**
     * Recherche les newsletter et leur dernier contenu
     *
     * @ApiDoc(
     * section = "Insciption",
     *  statusCodes={
     *      200="Returned when successful",
     *      404="Returned when user is not found"
     *  }
     * )
     * @View(serializerGroups={"all_inscriptions"})
     * @return array
     */
    public function getAllInsciptionListeDiffusionAction()
    {

        $orm = $this->getDoctrine();
        $inscriptions = $orm->getRepository('AppBundle:Inscription')->getAllWithListeDiffusion();

        return $inscriptions;
    }

}