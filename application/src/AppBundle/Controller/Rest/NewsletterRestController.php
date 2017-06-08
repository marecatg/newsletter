<?php

namespace AppBundle\Controller\Rest;

use AppBundle\Entity\ContenuNewsletter;
use AppBundle\Entity\Newsletter;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\Annotations\View;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Util\Codes;

class NewsletterRestController extends ParentRestController
{

    /**
     * Recherche les newsletter et leur dernier contenu
     *
     * @ApiDoc(
     * section = "Newsletter",
     *  output={"class"="Newsletter"},
     *  statusCodes={
     *      200="Returned when successful",
     *      404="Returned when user is not found"
     *  }
     * )
     * @View(serializerGroups={"newsletter_list"})
     * @return Response
     */
    public function getAllLastNewsletterAction()
    {

        $orm = $this->getDoctrine();
        $newsletters = $orm->getRepository('AppBundle:Newsletter')->findAll();

        return $newsletters;
    }

    /**
     * Recherche les newsletters d'une campagne.
     * Id -1 pour rechercher les newsletters qui n'ont pas de campagne.
     *
     * @ApiDoc(
     * section = "Newsletter",
     *  output={"class"="Newsletter"},
     *  statusCodes={
     *      200="Returned when successful",
     *      404="Returned when user is not found"
     *  }
     * )
     * @View(serializerGroups={"newsletter_list"})
     * @param $idCampagne integer
     * @return Response
     */
    public function getNewsletterByCampagneAction($idCampagne)
    {

        $orm = $this->getDoctrine();

        if ($idCampagne === 'null') {
            return $this->view('Id obligatoire', Codes::HTTP_BAD_REQUEST);
        } else if ($idCampagne == -1) {
            $newsletters = $orm->getRepository('AppBundle:Newsletter')->getNewsletterNotInCampagne();
        } else {
            $newsletters = $orm->getRepository('AppBundle:Campagne')->find($idCampagne)->getNewsletters();
        }

        return $newsletters;
    }

    /**
     * Recherche une newsletter et son dernier contenu
     *
     * @ApiDoc(
     * section = "Newsletter",
     *  output={"class"="Newsletter"},
     *  statusCodes={
     *      200="Returned when successful",
     *      404="Returned when user is not found"
     *  }
     * )
     * @View(serializerGroups={"newsletter_last_contenu"})
     * @param $id integer
     * @return Newsletter
     */
    public function getNewsletterAction($id)
    {

        if ($id == 'null') {
            return $this->view('Id obligatoire', Codes::HTTP_BAD_REQUEST);
        }

        $orm = $this->getDoctrine();
        $newsletter = $orm->getRepository('AppBundle:Newsletter')->getLast($id);

        return $newsletter;
    }

    /**
     * Creer une newsletter
     *
     * @ApiDoc(
     * section = "Newsletter",
     *  output={"class"="Response"},
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Est retourné lorsque le destinataire est invalide"
     *  }
     * )
     * @View(serializerGroups={"newsletter_list"})
     * @param $request Request
     * @return object
     */
    public function postNewsletterAction(Request $request)
    {

        $params = json_decode($request->getContent(), true);
        $orm = $this->getDoctrine();

        $newsletter = new Newsletter();
        $contenu = new ContenuNewsletter();

        if (!isset($params['newsletter'])) {
            return $this->view('Param newsletter non trouvé', Codes::HTTP_BAD_REQUEST);
        }
        if (isset($params['newsletter']['nom']) && $params['newsletter']['nom'] != null) {
            $newsletter->setNom($params['newsletter']['nom']);
        }

        if (isset($params['newsletter']['corps']) && $params['newsletter']['corps'] != null) {
            $contenu->setContenuHTML($params['newsletter']['corps']);
        }

        if (isset($params['newsletter']['campagneId']) && $params['newsletter']['campagneId'] != null) {
            $campagne = $orm->getRepository('AppBundle:Campagne')->find($params['newsletter']['campagneId']);
            if ($campagne == null) {
                return $this->view('Campagne d\'id '.$params['newsletter']['campagneId'].' non trouvé', Codes::HTTP_BAD_REQUEST);
            }
            $newsletter->setCampagne($campagne);
        }

        if (isset($params['newsletter']['periodiciteValeur']) && $params['newsletter']['periodiciteValeur'] != null) {
            $newsletter->setPeriodiciteValeur($params['newsletter']['periodiciteValeur']);
        }

        if (isset($params['newsletter']['periodiciteUnite']) && $params['newsletter']['periodiciteUnite'] != null) {
            $newsletter->setPeriodiciteUnite($params['newsletter']['periodiciteUnite']);
        }

        if (isset($params['newsletter']['dateEnvoi']) && $params['newsletter']['dateEnvoi'] != null) {
            $newsletter->setDateProchainEnvoi(new \DateTime($params['newsletter']['dateEnvoi']));
        }

        $contenu->setDateModification(new \DateTime());
        $newsletter->setCreateur($this->getUser());
        $contenu->setNewsletter($newsletter);
        $contenus = [$contenu];
        $newsletter->setContenus($contenus);

        return $this->processForm($newsletter);
    }

    /**
     * Modifier une newsletter
     *
     * @ApiDoc(
     * section = "Newsletter",
     *  output={"class"="Response"},
     *  statusCodes={
     *      200="Returned when successful",
     *      400="Est retourné lorsque le destinataire est invalide"
     *  }
     * )
     * @View(serializerGroups={"newsletter_list"})
     * @param $request Request
     * @return object
     */
    public function putNewsletterAction(Request $request)
    {

        $params = json_decode($request->getContent(), true);
        $orm = $this->getDoctrine();

        if (!isset($params['newsletter']) && !isset($params['newsletter']['id'])) {
            return $this->view('Param newsletter non trouvé ou il n\'a pas d\'id', Codes::HTTP_BAD_REQUEST);
        }
        $newsletter = $orm->getRepository('AppBundle:Newsletter')->find($params['newsletter']['id']);
        $contenu = new ContenuNewsletter();
        if (isset($params['newsletter']['nom']) && $params['newsletter']['nom'] != null) {
            $newsletter->setNom($params['newsletter']['nom']);
        }

        if (isset($params['newsletter']['corps']) && $params['newsletter']['corps'] != null) {
            $contenu->setContenuHTML($params['newsletter']['corps']);
        }

//        if (isset($params['newsletter']['campagneId']) && $params['newsletter']['campagneId'] != null) {
//            $campagne = $orm->getRepository('AppBundle:Campagne')->find($params['newsletter']['campagneId']);
//            if ($campagne == null) {
//                return $this->view('Campagne d\'id '.$params['newsletter']['campagneId'].' non trouvé', Codes::HTTP_BAD_REQUEST);
//            }
//            $newsletter->setCampagne($campagne);
//        }

        if (isset($params['newsletter']['periodiciteValeur']) && $params['newsletter']['periodiciteValeur'] != null) {
            $newsletter->setPeriodiciteValeur($params['newsletter']['periodiciteValeur']);
        }

        if (isset($params['newsletter']['periodiciteUnite']) && $params['newsletter']['periodiciteUnite'] != null) {
            $newsletter->setPeriodiciteUnite($params['newsletter']['periodiciteUnite']);
        }

        if (isset($params['newsletter']['dateEnvoi']) && $params['newsletter']['dateEnvoi'] != null) {
            $newsletter->setDateProchainEnvoi(new \DateTime($params['newsletter']['dateEnvoi']));
        }

        $contenu->setDateModification(new \DateTime());
        $newsletter->setCreateur($this->getUser());
        $contenu->setNewsletter($newsletter);
        $contenus = $newsletter->getContenus();
        $contenus[] = $contenu;
        $newsletter->setContenus($contenus);

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

    /**
     * Supprime une newsletter de l'application
     *
     * @ApiDoc(
     * section = "Newsletter",
     *  statusCodes={
     *      200="Returned when successful",
     *      404="Returned when user is not found"
     *  }
     * )
     * @View()
     * @param $id integer
     * @return Response
     */
    public function deleteNewsletterAction($id)
    {

        $orm = $this->getDoctrine();

        if ($id == 'null') {
            return $this->view('Id obligatoire', Codes::HTTP_BAD_REQUEST);
        }

        $newsletter = $orm->getRepository('AppBundle:Newsletter')->find($id);

        $orm->getManager()->remove($newsletter);
        $orm->getManager()->flush();

        return $this->view('Le destinataire a bien été supprimé', Codes::HTTP_OK);
    }

}