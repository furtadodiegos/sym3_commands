<?php
/**
 * Created by PhpStorm.
 * User: diegofurtado
 * Date: 25/09/17
 * Time: 21:08
 */

namespace AbstractBundle\test;


use AppBundle\Entity\Email;
use AppBundle\Entity\Url;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProjectTestCase extends KernelTestCase
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var ObjectManager
     */
    protected $em;

    public static function setUpBeforeClass()
    {
        self::bootKernel();
    }

    protected function setUp()
    {
        $this->em = $this->getService('doctrine')->getManager();
        $this->purgeDatabase();
        $this->client = $this->createClient();
    }

    private function createClient()
    {
        $client = $this->getService('test.client');
        $client->setServerParameters(array());

        return $client;
    }

    protected function getService($service)
    {
        return self::$kernel->getContainer()
            ->get($service);
    }

    private function purgeDatabase()
    {
        $purger = new ORMPurger($this->em);
        $purger->purge();
    }

    protected function generateData($limit = 1)
    {
        //Gera uma Url/Entity
        $url = new Url();
        $url->setNome('https://www.google.com.br/');

        $this->em->persist($url);
        $this->em->flush();

        //Gera a quantida de $limit de Email/Entity
        for ($i = 0; $i < $limit; $i++) {
            $email = new Email();
            $email->setNome('email_'.$i)
                ->setCodUrl($this->em->getRepository('AppBundle:Url')->find($url->getId()));

            $this->em->persist($email);
        }

        $this->em->flush();
    }

    protected function tearDown()
    {
    }
}