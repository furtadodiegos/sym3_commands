<?php
/**
 * Created by PhpStorm.
 * User: diegofurtado
 * Date: 25/09/17
 * Time: 20:25
 */

namespace AbstractBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

abstract class AbstractController extends Controller
{

    /**
     * @param null $service
     * @return object
     */
    protected function getService($service = null)
    {
        if ($service) {
            return $this->get($service);
        } else {
            $arr = explode('\\', get_class($this));
            $arr[count($arr) - 1] = (str_replace('Controller', '', $arr[count($arr) - 1])) . '.service';

            return $this->get(strtolower(end($arr)));
        }
    }

    /**
     * @param $data
     * @param int $statusCode
     * @param string $header
     * @return Response
     */
    protected function renderResponse($data, $statusCode = 200, $header = 'hal+json')
    {
        $normalizers = array(new GetSetMethodNormalizer());
        $encoders = array("json" => new JsonEncoder());

        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($data, 'json');

        $response = new Response($json, $statusCode);

        $response->headers->set("Content-Type", 'application/'.$header);

        return $response;
    }
}