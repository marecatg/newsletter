<?php

namespace AppBundle\Controller;

/**
 * Created by PhpStorm.
 * User: Gaetan
 * Date: 19/10/2016
 * Time: 10:47
 */

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\Controller\Annotations\View;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TestRestController extends FOSRestController
{

    /**
     * Retrieves all stages
     *
     *
     * @ApiDoc(
     * section = "Test",
     *  output={"class"="String"},
     *  statusCodes={
     *      200="Returned when successful",
     *      404="Returned when user is not found"
     *  }
     * )
     *
     * @View(serializerEnableMaxDepthChecks=true, serializerGroups={})
     *
     * @return String
     */
    public function getTestAction()
    {

        $view = $this->view("I'm alive", Codes::HTTP_OK);

        return $this->handleView($view);
    }

}