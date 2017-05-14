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
     * @View(serializerGroups={"destinataire"})
     * @param $id integer
     * @return Response
     */
    public function getDestinataireAction($id)
    {
        if ($id == 'null') {
            return $this->view('Id obligatoire', Codes::HTTP_BAD_REQUEST);
        }

        $orm = $this->getDoctrine();
        $destinataire = $orm->getRepository('AppBundle:Destinataire')->find($id);

//        if ($destinataire == null) {
//            return $this->view('Destinaiatre non trouvé avec l\'id '.$id, Codes::HTTP_NOT_FOUND);
//        }

        return $destinataire;
    }

    /**
     * Recherche les destinataires d'une liste de diffusion.
     * Id -1 pour rechercher les destinataires qui n'ont pas de liste.
     *
     * @ApiDoc(
     * section = "Destinataire",
     *  output={"class"="Destinataire"},
     *  statusCodes={
     *      200="Returned when successful",
     *      404="Returned when user is not found"
     *  }
     * )
     * @View(serializerGroups={"destinataire"})
     * @param $idListeDiffusion integer
     * @return object
     */
    public function getDestinataireByListeDiffusionAction($idListeDiffusion)
    {

        $orm = $this->getDoctrine();

        if ($idListeDiffusion == 'null') {
            return $this->view('Id obligatoire', Codes::HTTP_BAD_REQUEST);
        } else if ($idListeDiffusion == -1) {
            $destinataires = $orm->getRepository('AppBundle:Destinataire')->getDestinataireNotInListeDiffusion();
        } else {
            $destinataires = $orm->getRepository('AppBundle:ListeDiffusion')->find($idListeDiffusion)->getDestinataires();
        }

        return $destinataires;
    }

    /**
     * Supprime un destinataire de l'application
     *
     * @ApiDoc(
     * section = "Destinataire",
     *  output={"class"="Destinataire"},
     *  statusCodes={
     *      200="Returned when successful",
     *      404="Returned when user is not found"
     *  }
     * )
     * @View(serializerGroups={"destinataire"})
     * @param $id integer
     * @return Response
     */
    public function deleteDestinataireAction($id)
    {

        $orm = $this->getDoctrine();

        if ($id == 'null') {
            return $this->view('Id obligatoire', Codes::HTTP_BAD_REQUEST);
        }

        $destinataire = $orm->getRepository('AppBundle:Destinataire')->find($id);

        $orm->getManager()->remove($destinataire);
        $orm->getManager()->flush();

        return $this->view('Le destinataire a bien été supprimé', Codes::HTTP_OK);
    }


    /**
     * Retourne tous les destinataires
     *
     * @ApiDoc(
     * section = "Destinataire",
     *  output={"class"="Destinataire"},
     *  statusCodes={
     *      200="Returned when successful",
     *      404="Returned when user is not found"
     *  }
     * )
     * @View(serializerGroups={"destinataire"})
     * @return Response
     */
    public function getAllDestinataireAction()
    {

        $orm = $this->getDoctrine();
        $destinataires = $orm->getRepository('AppBundle:Destinataire')->findAll();

        return $destinataires;
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
     * @View(serializerGroups={"destinataire"})
     * @param $request Request
     * @return object
     */
    public function postDestinataireAction(Request $request)
    {

        $params = json_decode($request->getContent(), true);

        $destinataire = new Destinataire();
        if (!isset($params['destinataire'])) {
            return $this->view('Param destinataire non trouvé', Codes::HTTP_BAD_REQUEST);
        }
        if (!isset($params['listeId'])) {
            return $this->view('Param listeId non trouve', Codes::HTTP_BAD_REQUEST);
        }

        $liste = $this->getDoctrine()->getRepository('AppBundle:ListeDiffusion')->find($params['listeId']);
        if ($liste === null) {
            return $this->view('Liste de diffusion non trouve', Codes::HTTP_BAD_REQUEST);
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


        $dests = $liste->getDestinataires();
        $dests[] = $destinataire;
        $liste->setDestinataires($dests);
        $listes = array();
        $listes[] = $liste;
        $destinataire->setListesDiffusion($listes);

        return $this->processForm($destinataire);
    }

    /**
     * Modifier un destinataire
     *
     * @ApiDoc(
     * section = "Destinataire",
     *  output={"class"="AppBundle\Entity\Destinataire"},
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Est retourné lorsque le destinataire est invalide"
     *  }
     * )
     * @View(serializerGroups={"destinataire"})
     * @param $request Request
     * @return object
     */
    public function putDestinataireAction(Request $request)
    {

        $params = json_decode($request->getContent(), true);

        if (!isset($params['destinataire']) || !isset($params['destinataire']['id']) ||
            $params['destinataire']['id'] === null) {
            return $this->view('Param destinataire non trouvé', Codes::HTTP_BAD_REQUEST);
        }

        $orm = $this->getDoctrine();
        $destinataire = $orm->getRepository('AppBundle:Destinataire')->find($params['destinataire']['id']);

        if (!$destinataire) {
            return $this->view('Destinataire non trouvé', Codes::HTTP_BAD_REQUEST);
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
     * @return object
     */
    private function processForm($destinataire)
    {
        $em = $this->getDoctrine()->getManager();

        $validator = $this->get('validator');
        $errors = $validator->validate($destinataire);

        if (count($errors) > 0) {
            return $this->view($errors, Codes::HTTP_BAD_REQUEST);
        } else {
            try {
                $em->persist($destinataire);
                $em->flush();
            } catch (\Exception $ex) {
                return $this->view($ex->getMessage(), Codes::HTTP_BAD_REQUEST);
            }
        }

        return $this->view($destinataire, Codes::HTTP_OK);
    }
}