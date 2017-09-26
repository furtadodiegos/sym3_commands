<?php
/**
 * Created by PhpStorm.
 * User: diegofurtado
 * Date: 25/09/17
 * Time: 20:35
 */

namespace AbstractBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

interface InterfaceController
{
    /**
     * @Route("/$route")
     * @Method("GET")
     * @return Response
     */
    public function getAction();
}