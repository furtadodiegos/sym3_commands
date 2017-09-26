<?php
/**
 * Created by PhpStorm.
 * User: diegofurtado
 * Date: 25/09/17
 * Time: 20:34
 */

namespace AppBundle\Controller;


use AbstractBundle\Controller\AbstractController;
use AbstractBundle\Controller\InterfaceController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class EmailController extends AbstractController implements InterfaceController
{

    /**
     * @Route("/email")
     * @Method("GET")
     * @return Response
     */
    public function getAction()
    {
        $emails = $this->getDoctrine()->getRepository('AppBundle:Email')->getLastestEmails();

        return $this->renderResponse($emails, 200);
    }
}