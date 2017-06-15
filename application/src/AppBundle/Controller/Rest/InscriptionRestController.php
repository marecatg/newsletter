<?php
/**
 * Created by PhpStorm.
 * User: Gaetan
 * Date: 12/06/2017
 * Time: 19:56
 */

namespace AppBundle\Controller\Rest;

use AppBundle\Entity\Inscription;
use AppBundle\Entity\Newsletter;
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
     * section = "Inscription",
     *  statusCodes={
     *      200="Returned when successful",
     *      404="Returned when user is not found"
     *  }
     * )
     * @View(serializerGroups={"all_inscriptions"})
     * @return array
     */
    public function getAllInscriptionListeDiffusionAction()
    {

        $orm = $this->getDoctrine();
        $inscriptions = $orm->getRepository('AppBundle:Inscription')->getAllWithListeDiffusion();

        return $inscriptions;
    }

    /**
     * Mettre à jour les inscriptions à une newsletter
     *
     * @ApiDoc(
     * section = "Inscription",
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Returned for bad request parameters"
     *  }
     * )
     * @View()
     * @param $request
     * @return object
     */
    public function putInscriptionNewsletterListeDiffusionAction(Request $request)
    {

        $params = json_decode($request->getContent(), true);
        $orm = $this->getDoctrine();

        if (!isset($params['inscriptions']) || !isset($params['idNewsletter'])) {
            return $this->view('Param insciprtions ou idNewsletter non trouvé', Codes::HTTP_BAD_REQUEST);
        }

        $newsletter = $orm->getRepository('AppBundle:Newsletter')->find($params['idNewsletter']);
        try {
            foreach ($newsletter->getInscriptions() as $i) {
                $orm->getManager()->remove($i);
            }
        } catch (\Exception $e) {
            return $this->view($e->getMessage(), Codes::HTTP_BAD_REQUEST);
        }
        $listeInscriptions = array();

        foreach ($params['inscriptions'] as $i) {
            $liste = $orm->getRepository('AppBundle:ListeDiffusion')->find($i['idListeSource']);
            foreach ($liste->getDestinataires() as $dest) {
                $inscription = new Inscription();
                $inscription->setDestinataire($dest);
                $inscription->setListeDiffusionSource($liste->getId());
                $inscription->setNewsletter($newsletter);
                $listeInscriptions[] = $inscription;
            }
        }

        $newsletter->setInscriptions($listeInscriptions);

        return $this->processForm($newsletter);
    }

    /**
     * save entity if is valid
     * @param Newsletter $newsletter
     *
     * @return object
     */
    private function processForm($newsletter)
    {
        $em = $this->getDoctrine()->getManager();

        $validator = $this->get('validator');
        $errors = $validator->validate($newsletter);

        if (count($errors) > 0) {
            return $this->view($errors, Codes::HTTP_BAD_REQUEST);
        } else {
            try {
                $em->persist($newsletter);
                $em->flush();
            } catch (\Exception $ex) {
                return $this->view($ex->getMessage(), Codes::HTTP_BAD_REQUEST);
            }
        }

        return $this->view($newsletter, Codes::HTTP_OK);
    }

}