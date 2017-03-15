<?php
/**
 * Created by PhpStorm.
 * User: Gaetan
 * Date: 15/03/2017
 * Time: 16:49
 */

namespace AppBundle\Controller\Rest;

use FOS\RestBundle\Controller\Annotations\View;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Util\Codes;


class CampagneRestController extends ParentRestController
{
    /**
     * Recherche toutes les liste de diffusion
     *
     * @ApiDoc(
     * section = "Campagne",
     *  output={"class"="Campagne"},
     *  statusCodes={
     *      200="Returned when successful",
     *      404="Returned when list is not found"
     *  }
     * )
     * @View(serializerGroups={"campagne_info"})
     *
     * @return Response
     */
    public function getAllCampagneAction()
    {

        $orm = $this->getDoctrine();
        $listes = $orm->getRepository('AppBundle:Campagne')->findAll();

        return $listes;
    }
}