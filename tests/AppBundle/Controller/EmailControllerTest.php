<?php
/**
 * Created by PhpStorm.
 * User: diegofurtado
 * Date: 25/09/17
 * Time: 21:33
 */

namespace Tests\AppBundle\Controller;


use AbstractBundle\test\ProjectTestCase;

class EmailControllerTest extends ProjectTestCase
{

    protected function setUp()
    {
        parent::setUp();

        $this->generateData(15);
    }

    public function testGetAction()
    {
        $this->client->request('GET', '/email', []);

        $data = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(10, count($data));
    }
}