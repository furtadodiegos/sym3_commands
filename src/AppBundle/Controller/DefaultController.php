<?php
/**
 * Created by PhpStorm.
 * User: diegofurtado
 * Date: 25/09/17
 * Time: 22:59
 */

namespace AppBundle\Controller;


use AbstractBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends AbstractController
{

    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {

    }
}