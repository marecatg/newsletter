<?php

namespace AppBundle\Controller\Rest;

use AppBundle\Entity\Destinataire;
use FOS\RestBundle\Controller\Annotations\View;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Util\Codes;

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
     * @View()
     *
     * @param $id integer
     * @return Response
     */
    public function getDestinataireAction($id)
    {

        $orm = $this->getDoctrine();
        $destinataire = $orm->getRepository('AppBundle:Destinataire')->find($id);

        return $destinataire;
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
     * @View()
     * @param $request Request
     * @return Response
     */
    public function postDestinataireAction(Request $request)
    {

        $params = json_decode($request->getContent(), true);

        $destinataire = new Destinataire();
        if (!isset($params['destinataire'])) {
            return $this->view(null, Codes::HTTP_BAD_REQUEST);
        }
        if (isset($params['destinataire']['nom']) && $params['destinataire']['nom'] != null) {
            $destinataire->setNom($params['destinataire']['nom']);
        }

        if (isset($params['destinataire']['prenom']) && $params['destinataire']['prenom'] != null) {
            $destinataire->setPrenom($params['destinataire']['prenom']);
        }

        if (isset($params['destinataire']['email']) && $params['destinataire']['email'] != null) {
            $destinataire->setEmail($params['destinataire']['email']);
        }

        return $this->processForm($destinataire);
    }

    /**
     * save entity if is valid
     * @param Destinataire $destinataire
     *
     * @return Respone
     */
    private function processForm($destinataire)
    {
        $em = $this->getDoctrine()->getManager();
        $translator = $this->get('translator');

        $validator = $this->get('validator');
        $errors = $validator->validate($destinataire);

        if (count($errors) > 0) {
            return $this->view($errors, Codes::HTTP_BAD_REQUEST);
        } else {
            try {
                $em->persist($destinataire);
                $em->flush();
            } catch (\Exception $ex) {
//                return $this->view($translator->trans('actionrest.mandatory_error'), Codes::HTTP_BAD_REQUEST);
                return $this->view($ex, Codes::HTTP_BAD_REQUEST);
            }
        }

        return $this->view(array('id' => $destinataire->getId()), Codes::HTTP_OK);
    }
}