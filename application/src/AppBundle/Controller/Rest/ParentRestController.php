<?php

namespace AppBundle\Controller\Rest;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Response;

class ParentRestController extends FOSRestController
{
    protected function returnObject($object) {
        if($object == null) {
            $view = $this->view($object, Codes::HTTP_NOT_FOUND);
        } else {
            $view = $this->view($object, Codes::HTTP_OK   );
        }

        return $this->handleView($view);
    }
}