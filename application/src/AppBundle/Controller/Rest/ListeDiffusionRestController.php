<?php

namespace AppBundle\Controller\Rest;

use AppBundle\Entity\Destinataire;
use AppBundle\Entity\ListeDiffusion;
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
     * section = "Liste Diffusion",
     *  output={"class"="ListeDiffusion"},
     *  statusCodes={
     *      200="Returned when successful",
     *      404="Returned when list is not found"
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

    /**
     * Modifie une liste de diffusion
     *
     * @ApiDoc(
     * section = "Liste Diffusion",
     *  output={"class"="Destinataire"},
     *  statusCodes={
     *      200="Returned when successful",
     *      500="Returned when error occured"
     *  }
     * )
     * @View(serializerGroups={"liste_info"})
     *
     * @param $request
     * @return Response
     */
    public function putListeDiffusionAction(Request $request)
    {

        $params = json_decode($request->getContent(), true);
        $orm = $this->getDoctrine();
        $liste = null;
        if (isset($params['liste']) && isset($params['liste']['id'])) {
            $liste = $orm->getRepository('AppBundle:ListeDiffusion')->find($params['liste']['id']);
        }
        if ($liste == null) {
            return $this->view('Liste non trouvé', Codes::HTTP_BAD_REQUEST);
        }
        if (isset($params['liste']['users']) && $params['liste']['users'] != null) {
            $destinataires = array();
            foreach ($params['liste']['users'] as $user) {
                if (!isset($user['id']) || $user['id'] == null) {
                    return $this->view('Un destinataire n\'a pas d\'id', Codes::HTTP_BAD_REQUEST);
                }
                $destinataires[] = $orm->getManager()->getRepository('AppBundle:Destinataire')->find($user['id']);
//                $destinataire = $orm->getRepository('AppBundle:Destinataire')->find($user['id']);
//                if ( $destinataire == null) {
//                    return $this->view('Destinataire non trouvé avec l\'id '.$user['id'], Codes::HTTP_BAD_REQUEST);
//                }
//                $listesDuDest = $destinataire->getListesDiffusion();
//                $trouve = false;
//                foreach($listesDuDest as $l) {
//                    if ($l->getId() == $liste->getId()) {
//                        $l = $liste;
//                        $trouve = true;
//                    }
//                }
//                if (!$trouve) {
//                    $listesDuDest[] = $liste;
//                }
//                $destinataire->setListesDiffusion($listesDuDest);
//                $destinataires[] = $destinataire;
            }
            $liste->setDestinataires($destinataires);
        }

        if (isset($params['liste']['nom']) || $params['liste']['nom'] != null) {
            $liste->setNom($params['liste']['nom']);
        }

        return $this->processForm($liste);
    }

    /**
     * save entity if is valid
     * @param ListeDiffusion $liste
     *
     * @return Respone
     */
    private function processForm($liste)
    {
        $em = $this->getDoctrine()->getManager();

        $validator = $this->get('validator');
        $errors = $validator->validate($liste);

        if (count($errors) > 0) {
            return $this->view($errors, Codes::HTTP_BAD_REQUEST);
        } else {
            try {
                $em->persist($liste);
                $em->flush();
            } catch (\Exception $ex) {
                return $this->view($ex->getMessage(), Codes::HTTP_BAD_REQUEST);
            }
        }

        return $this->view(array('liste' => $liste, Codes::HTTP_OK));
    }
}